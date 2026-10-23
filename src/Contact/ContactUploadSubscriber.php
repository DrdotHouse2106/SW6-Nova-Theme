<?php declare(strict_types=1);

namespace Nova\NovaTheme\Contact;

use Shopware\Core\Content\MailTemplate\Service\Event\MailBeforeValidateEvent;
use Shopware\Core\PlatformRequest;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Service\ResetInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Datei-Anhänge im Shopware-Kontaktformular (Plugin-Konfiguration „Kontaktformular“).
 *
 * - Vor dem Absenden: Anzahl, Größe und Dateityp prüfen; bei Fehlern antwortet das Formular mit einer Meldung.
 * - Beim Mailversand: die Dateien hängen an der Kontaktformular-Mail an den Shop. Eine Kopie an den
 *   Absender bekommt keine Anhänge. Die Dateien werden nirgends gespeichert.
 *
 * Der Request wird beim Absenden gemerkt: Flows können erst nach der Antwort laufen
 * (Shopware 6.8 bzw. FLOW_EXECUTION_AFTER_BUSINESS_PROCESS), dann ist der RequestStack schon leer.
 */
class ContactUploadSubscriber implements EventSubscriberInterface, ResetInterface
{
    public const FIELD = 'novaFiles';
    public const ROUTE = 'frontend.form.contact.send';

    /** Erlaubte Endungen: Bilder, Dokumente, Archive, 3D- und CAD-Formate – keine ausführbaren oder Web-Dateien */
    public const EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'gif', 'webp', 'heic', 'heif',
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'odt', 'ods', 'csv', 'txt', 'rtf',
        'zip',
        'stl', '3mf', 'obj', 'step', 'stp', 'iges', 'igs', 'amf', 'ply', 'wrl', 'x3d', 'dxf', 'dwg',
    ];

    private ?Request $request = null;

    public function __construct(
        private readonly SystemConfigService $config,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onController',
            MailBeforeValidateEvent::class => 'onMail',
        ];
    }

    public function onController(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        if (!$event->isMainRequest() || $request->attributes->get('_route') !== self::ROUTE) {
            return;
        }

        $this->request = null;
        $salesChannelId = $this->salesChannelId($request);
        if ($salesChannelId === null || !$this->isActive($salesChannelId)) {
            return;
        }

        $error = $this->validate($this->files($request), $salesChannelId);
        if ($error === null) {
            $this->request = $request;

            return;
        }

        $html = '<div role="alert" class="alert alert-danger d-flex align-items-center"><div class="alert-content-container"><div class="alert-content">'
            . htmlspecialchars($error, \ENT_QUOTES)
            . '</div></div></div>';

        $event->setController(static fn (): JsonResponse => new JsonResponse([['type' => 'danger', 'alert' => $html]]));
    }

    public function onMail(MailBeforeValidateEvent $event): void
    {
        $request = $this->request;
        if ($request === null) {
            return;
        }

        $files = $this->files($request);
        if ($files === []) {
            return;
        }

        // Kopie an den Absender (falls ein Flow sie verschickt) ohne Anhänge
        $data = $event->getData();
        $sender = mb_strtolower(trim((string) $request->request->get('email', '')));
        $recipients = \is_array($data['recipients'] ?? null) ? array_map('mb_strtolower', array_keys($data['recipients'])) : [];
        if ($sender !== '' && \in_array($sender, $recipients, true)) {
            return;
        }

        $attachments = \is_array($data['binAttachments'] ?? null) ? $data['binAttachments'] : [];
        foreach ($files as $file) {
            $content = is_file($file->getPathname()) ? file_get_contents($file->getPathname()) : false;
            if ($content === false) {
                continue;
            }

            $attachments[] = [
                'content' => $content,
                'fileName' => $this->safeName($file->getClientOriginalName()),
                'mimeType' => $this->mimeType($file),
            ];
        }

        $event->addData('binAttachments', $attachments);
    }

    public function reset(): void
    {
        $this->request = null;
    }

    /**
     * @param list<UploadedFile> $files
     */
    private function validate(array $files, string $salesChannelId): ?string
    {
        if ($files === []) {
            return null;
        }

        $maxFiles = max(1, $this->config->getInt('NovaTheme.config.contactUploadMaxFiles', $salesChannelId) ?: 5);
        $maxMb = max(1, $this->config->getInt('NovaTheme.config.contactUploadMaxMb', $salesChannelId) ?: 10);
        $maxTotalMb = max($maxMb, $this->config->getInt('NovaTheme.config.contactUploadMaxTotalMb', $salesChannelId) ?: 20);

        if (\count($files) > $maxFiles) {
            return $this->translator->trans('novaTheme.contactUpload.errorCount', ['%count%' => $maxFiles]);
        }

        $total = 0;
        foreach ($files as $file) {
            $name = $this->safeName($file->getClientOriginalName());

            if (!$file->isValid()) {
                return $this->translator->trans('novaTheme.contactUpload.errorFailed', ['%name%' => $name]);
            }

            if (!\in_array(mb_strtolower($file->getClientOriginalExtension()), self::EXTENSIONS, true)) {
                return $this->translator->trans('novaTheme.contactUpload.errorType', ['%name%' => $name]);
            }

            $size = (int) $file->getSize();
            if ($size > $maxMb * 1024 * 1024) {
                return $this->translator->trans('novaTheme.contactUpload.errorSize', ['%name%' => $name, '%size%' => $maxMb]);
            }

            $total += $size;
        }

        if ($total > $maxTotalMb * 1024 * 1024) {
            return $this->translator->trans('novaTheme.contactUpload.errorTotal', ['%size%' => $maxTotalMb]);
        }

        return null;
    }

    /**
     * @return list<UploadedFile>
     */
    private function files(Request $request): array
    {
        $raw = $request->files->get(self::FIELD);
        $raw = \is_array($raw) ? $raw : [$raw];

        return array_values(array_filter($raw, static fn ($file): bool => $file instanceof UploadedFile));
    }

    private function mimeType(UploadedFile $file): string
    {
        try {
            return $file->getMimeType() ?? 'application/octet-stream';
        } catch (\Throwable) {
            return 'application/octet-stream';
        }
    }

    private function isActive(string $salesChannelId): bool
    {
        return $this->config->getBool('NovaTheme.config.contactUpload', $salesChannelId);
    }

    private function salesChannelId(Request $request): ?string
    {
        $id = $request->attributes->get(PlatformRequest::ATTRIBUTE_SALES_CHANNEL_ID);

        return \is_string($id) && $id !== '' ? $id : null;
    }

    private function safeName(string $name): string
    {
        $name = basename(str_replace('\\', '/', $name));
        $name = (string) preg_replace('/[^\w.\- ]+/u', '_', $name);

        return mb_substr(trim($name, ' .') ?: 'anhang', 0, 120);
    }
}
