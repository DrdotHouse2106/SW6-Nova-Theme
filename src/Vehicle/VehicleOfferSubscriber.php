<?php declare(strict_types=1);

namespace Nova\NovaTheme\Vehicle;

use Nova\NovaTheme\Product\ProductQuestionsSubscriber;
use Shopware\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use Shopware\Core\Framework\Validation\DataBag\DataBag;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Fahrzeugangebote: Ist am Produkt das Zusatzfeld „Status“ (Fahrzeugangebot) gesetzt, bekommt die Produktseite
 * die Erweiterung `novaVehicle`. Das Theme gibt dann über der Erlebniswelt den Fahrzeugkopf aus (Name, Status,
 * Preis, Datenblatt, Anruf-/WhatsApp-/Anfrage-Knöpfe) und blendet Kaufbox und Warenkorb-Knöpfe aus.
 *
 * Läuft vor ProductQuestionsSubscriber (-100): Bei Fahrzeugen bleibt das Kontaktformular an seiner Stelle im
 * Layout und ist Sprungziel von „Besichtigung anfragen“; Betreff und Nachricht werden vorbelegt.
 */
class VehicleOfferSubscriber implements EventSubscriberInterface
{
    public const EXTENSION = 'novaVehicle';

    public function __construct(
        private readonly SystemConfigService $systemConfigService,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [ProductPageLoadedEvent::class => ['onProductPageLoaded', -50]];
    }

    public static function statusOf(SalesChannelProductEntity $product): ?string
    {
        $customFields = $product->getTranslation('customFields');
        $status = \is_array($customFields) ? ($customFields[VehicleCustomFields::STATUS] ?? null) : null;

        return \is_string($status) && \in_array($status, VehicleCustomFields::STATUSES, true) ? $status : null;
    }

    public function onProductPageLoaded(ProductPageLoadedEvent $event): void
    {
        $salesChannelId = $event->getSalesChannelContext()->getSalesChannelId();
        if ($this->systemConfigService->get('NovaTheme.config.vehicleOffers', $salesChannelId) === false) {
            return;
        }

        $page = $event->getPage();
        $product = $page->getProduct();
        $status = self::statusOf($product);
        if ($status === null) {
            return;
        }

        $sold = $status === VehicleCustomFields::STATUS_SOLD;
        $name = ProductQuestionsSubscriber::shortName($product);
        $number = $product->getProductNumber();

        [$phoneHref, $phoneLabel] = $this->phone($salesChannelId);
        $whatsappHref = $sold ? null : $this->whatsapp($salesChannelId, $name, $number);

        $formSlotId = null;
        $formData = new DataBag();
        $cmsPage = $page->getCmsPage();
        if ($cmsPage !== null) {
            [$slot] = ProductQuestionsSubscriber::findContactForm($cmsPage);
            if ($slot !== null) {
                $formSlotId = $slot->getId();
                $subjectKey = $sold ? 'novaTheme.vehicle.subjectSold' : 'novaTheme.vehicle.subject';
                $formData->set('subject', $this->translator->trans($subjectKey, ['%name%' => $name, '%number%' => $number]));
                $formData->set('comment', $this->translator->trans('novaTheme.productQuestions.comment', ['%number%' => $number]) . "\n\n");
            }
        }

        // Verkaufte Fahrzeuge: Seitentitel ohne „… kaufen“ aus der SEO-Vorlage
        if ($sold) {
            $page->getMetaInformation()?->setMetaTitle($this->translator->trans('novaTheme.vehicle.metaTitleSold', ['%name%' => $product->getTranslation('name') ?? $name]));
        }

        $page->addExtension(self::EXTENSION, new VehicleOfferStruct($status, $phoneHref, $phoneLabel, $whatsappHref, $formSlotId, $formData));
    }

    /**
     * Telefon aus der Plugin-Konfiguration, sonst aus den Stammdaten (Firmenangaben), sonst aus der Topbar.
     *
     * @return array{0: ?string, 1: ?string}
     */
    private function phone(string $salesChannelId): array
    {
        foreach (['NovaTheme.config.vehiclePhone', 'core.basicInformation.companyPhone', 'NovaTheme.config.topbarPhone'] as $key) {
            $value = $this->systemConfigService->get($key, $salesChannelId);
            if (!\is_string($value) || trim($value) === '') {
                continue;
            }
            $label = trim($value);
            $dial = (string) preg_replace('/[^0-9+]/', '', $label);
            $dial = ($dial !== '' && $dial[0] === '+' ? '+' : '') . str_replace('+', '', $dial);
            if (preg_match('/[0-9]{3,}/', $dial) === 1) {
                return ['tel:' . $dial, $label];
            }
        }

        return [null, null];
    }

    /**
     * wa.me-Link; die Nummer muss international angegeben sein (+49 … oder 0049 …).
     */
    private function whatsapp(string $salesChannelId, string $name, string $number): ?string
    {
        $value = $this->systemConfigService->get('NovaTheme.config.vehicleWhatsapp', $salesChannelId);
        if (!\is_string($value)) {
            return null;
        }
        $value = trim($value);
        if (!str_starts_with($value, '+') && !str_starts_with($value, '00')) {
            return null;
        }
        $digits = (string) preg_replace('/\D/', '', $value);
        if (str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);
        }
        if (\strlen($digits) < 7) {
            return null;
        }

        $textKey = $name !== '' ? 'novaTheme.vehicle.whatsappText' : 'novaTheme.vehicle.whatsappTextWithoutName';
        $text = $this->translator->trans($textKey, ['%name%' => $name, '%number%' => $number]);

        return 'https://wa.me/' . $digits . '?text=' . rawurlencode($text);
    }
}
