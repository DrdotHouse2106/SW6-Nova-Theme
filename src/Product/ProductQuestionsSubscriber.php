<?php declare(strict_types=1);

namespace Nova\NovaTheme\Product;

use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\CmsPageEntity;
use Shopware\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use Shopware\Core\Framework\Validation\DataBag\DataBag;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Sucht auf der Produktseite das erste Kontaktformular der Erlebniswelt und legt es als Erweiterung
 * `novaProductQuestions` an die Seite. Das Theme gibt es dann im Reiter „Fragen zum Produkt“ aus
 * (mit vorbelegtem Betreff und Artikelnummer) statt an seiner Stelle im Layout.
 *
 * Das Formular-Element bleibt im Layout, damit Empfänger, Datei-Upload und Captcha wie gewohnt greifen –
 * das Formular schickt weiter seine eigene slotId an die Kern-Route.
 */
class ProductQuestionsSubscriber implements EventSubscriberInterface
{
    public const EXTENSION = 'novaProductQuestions';

    private const NAME_MAX_LENGTH = 150;

    public function __construct(
        private readonly SystemConfigService $systemConfigService,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [ProductPageLoadedEvent::class => ['onProductPageLoaded', -100]];
    }

    public function onProductPageLoaded(ProductPageLoadedEvent $event): void
    {
        $salesChannelId = $event->getSalesChannelContext()->getSalesChannelId();
        if ($this->systemConfigService->get('NovaTheme.config.productQuestionsTab', $salesChannelId) === false) {
            return;
        }

        $page = $event->getPage();
        $cmsPage = $page->getCmsPage();
        // Ohne Element „Beschreibung & Bewertungen“ gibt es keinen Reiter – das Formular bleibt, wo es ist.
        if ($cmsPage === null || $cmsPage->getElementsOfType('product-description-reviews') === []) {
            return;
        }

        [$slot, $hiddenBlockId] = $this->findContactForm($cmsPage);
        if ($slot === null) {
            return;
        }

        $data = new DataBag();
        if ($this->systemConfigService->get('NovaTheme.config.productQuestionsPrefill', $salesChannelId) !== false) {
            $this->prefill($data, $page->getProduct());
        }

        $page->addExtension(self::EXTENSION, new ProductQuestionsStruct($slot, $hiddenBlockId, $data));
    }

    /**
     * @return array{0: ?CmsSlotEntity, 1: ?string}
     */
    private function findContactForm(CmsPageEntity $cmsPage): array
    {
        $best = null;
        $sections = $cmsPage->getSections()?->getElements() ?? [];
        foreach ($sections as $section) {
            foreach ($section->getBlocks()?->getElements() ?? [] as $block) {
                $slots = $block->getSlots()?->getElements() ?? [];
                foreach ($slots as $slot) {
                    if ($slot->getType() !== 'form' || $slot->getFieldConfig()->get('type')?->getValue() !== 'contact') {
                        continue;
                    }
                    $rank = [$section->getPosition(), $block->getPosition(), $slot->getSlot()];
                    if ($best !== null && $best['rank'] <= $rank) {
                        continue;
                    }
                    $onlyForms = array_filter($slots, static fn (CmsSlotEntity $s): bool => $s->getType() !== 'form') === [];
                    $best = ['rank' => $rank, 'slot' => $slot, 'block' => $onlyForms ? $block->getId() : null];
                }
            }
        }

        return $best === null ? [null, null] : [$best['slot'], $best['block']];
    }

    private function prefill(DataBag $data, SalesChannelProductEntity $product): void
    {
        $number = $product->getProductNumber();
        $name = $product->getTranslation('name');
        $name = \is_string($name) ? trim(strip_tags($name)) : '';
        if (mb_strlen($name) > self::NAME_MAX_LENGTH) {
            $name = rtrim(mb_substr($name, 0, self::NAME_MAX_LENGTH - 1)) . '…';
        }

        $subjectKey = $name !== '' ? 'novaTheme.productQuestions.subject' : 'novaTheme.productQuestions.subjectWithoutName';
        $data->set('subject', $this->translator->trans($subjectKey, ['%number%' => $number, '%name%' => $name]));
        $data->set('comment', $this->translator->trans('novaTheme.productQuestions.comment', ['%number%' => $number]) . "\n\n");
    }
}
