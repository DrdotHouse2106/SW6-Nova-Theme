<?php declare(strict_types=1);

namespace Nova\NovaTheme\Legal;

use Shopware\Core\Content\Cms\CmsPageEntity;
use Shopware\Core\Content\Cms\Events\CmsPageLoadedEvent;
use Shopware\Core\Content\Cms\SalesChannel\Struct\TextStruct;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Platzhalter in Erlebniswelt-Texten je Verkaufskanal ersetzen, z. B. [[Shopname]] oder [[E-Mail]].
 *
 * Damit lassen sich Rechtstexte (Impressum, Datenschutz, AGB …) EINMAL als gemeinsames Layout pflegen
 * und in allen Shops zuweisen. Läuft serverseitig nach dem Laden der Seite – unabhängig vom Theme des
 * Verkaufskanals, also auch in Modalen (AGB im Checkout) und auf Shops mit anderem Theme.
 */
class LegalPlaceholderSubscriber implements EventSubscriberInterface
{
    private const CONFIG = 'NovaTheme.config.';

    public function __construct(private readonly SystemConfigService $config)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [CmsPageLoadedEvent::class => 'onCmsPageLoaded'];
    }

    public function onCmsPageLoaded(CmsPageLoadedEvent $event): void
    {
        if ($this->config->getBool(self::CONFIG . 'legalPlaceholdersDisabled', $event->getSalesChannelContext()->getSalesChannelId())) {
            return;
        }

        $map = null;

        foreach ($event->getResult() as $page) {
            if (!$page instanceof CmsPageEntity || $page->getSections() === null) {
                continue;
            }
            foreach ($page->getSections() as $section) {
                foreach ($section->getBlocks() ?? [] as $block) {
                    foreach ($block->getSlots() ?? [] as $slot) {
                        $data = $slot->getData();
                        if (!$data instanceof TextStruct) {
                            continue;
                        }
                        $content = $data->getContent();
                        if ($content === null || !str_contains($content, '[[')) {
                            continue;
                        }
                        $map ??= $this->buildMap($event);
                        $data->setContent(self::replace($content, $map));
                    }
                }
            }
        }
    }

    /**
     * Ersetzt bekannte Platzhalter; Groß-/Kleinschreibung und Leerzeichen innen sind egal.
     * Unbekannte Platzhalter bleiben stehen, damit Tippfehler auffallen.
     *
     * @param array<string, string> $map Schlüssel klein geschrieben, ohne Leerzeichen
     */
    public static function replace(string $content, array $map): string
    {
        return (string) preg_replace_callback(
            '/\[\[\s*([^\[\]<>]{1,40}?)\s*\]\]/u',
            static function (array $m) use ($map): string {
                $key = self::key($m[1]);

                return \array_key_exists($key, $map) ? $map[$key] : $m[0];
            },
            $content
        );
    }

    public static function key(string $name): string
    {
        return mb_strtolower((string) preg_replace('/[\s_]+/u', '', html_entity_decode($name, \ENT_QUOTES | \ENT_HTML5, 'UTF-8')));
    }

    /**
     * @return array<string, string>
     */
    private function buildMap(CmsPageLoadedEvent $event): array
    {
        $scId = $event->getSalesChannelContext()->getSalesChannelId();
        $request = $event->getRequest();

        $get = fn (string $key): string => trim((string) $this->config->get($key, $scId));
        $nova = fn (string $field): string => $get(self::CONFIG . $field);

        $baseUrl = (string) $request->attributes->get('sw-sales-channel-absolute-base-url', '');
        if ($baseUrl === '') {
            $baseUrl = $request->getSchemeAndHttpHost();
        }
        $host = (string) (parse_url($baseUrl, \PHP_URL_HOST) ?: $request->getHost());
        $domain = (string) preg_replace('/^www\./i', '', $host);

        $values = [
            'shopname' => $get('core.basicInformation.shopName'),
            'e-mail' => $nova('legalEmail') ?: $get('core.basicInformation.email'),
            'telefon' => $nova('legalPhone') ?: $nova('topbarPhone'),
            'telefax' => $nova('legalFax'),
            'whatsapp' => $nova('legalWhatsapp'),
            'domain' => $domain,
            'shop-url' => rtrim($baseUrl, '/'),
            'jahr' => date('Y'),
            'zusatz1' => $nova('legalExtra1'),
            'zusatz2' => $nova('legalExtra2'),
            'zusatz3' => $nova('legalExtra3'),
        ];

        $map = [];
        foreach ($values as $k => $v) {
            $map[$k] = htmlspecialchars($v, \ENT_QUOTES | \ENT_HTML5, 'UTF-8');
        }
        // Englische/alternative Schreibweisen
        $map['email'] = $map['mail'] = $map['e-mail'];
        $map['phone'] = $map['tel'] = $map['telefon'];
        $map['fax'] = $map['telefax'];
        $map['shop'] = $map['shopname'];
        $map['url'] = $map['shopurl'] = $map['shop-url'];

        return $map;
    }
}
