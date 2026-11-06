<?php declare(strict_types=1);

namespace Nova\NovaTheme\Product;

use Shopware\Core\Content\Cms\SalesChannel\Struct\ProductSliderStruct;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Produkt-Slider der Produktseiten-Erlebniswelt zeigen das gerade angezeigte Produkt nicht noch einmal
 * (z. B. „Weitere Angebote“ aus einer dynamischen Produktgruppe, die das Produkt selbst enthält).
 *
 * Bewusst an den Daten statt im Template: Bleibt danach nichts übrig, entfällt der Slider ganz (das
 * Kern-Template gibt ohne Produkte nichts aus) statt als leere Leiste stehen zu bleiben.
 */
class ProductSliderSelfFilterSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly SystemConfigService $systemConfigService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [ProductPageLoadedEvent::class => 'onProductPageLoaded'];
    }

    public function onProductPageLoaded(ProductPageLoadedEvent $event): void
    {
        $salesChannelId = $event->getSalesChannelContext()->getSalesChannelId();
        if ($this->systemConfigService->get('NovaTheme.config.productSliderHideCurrent', $salesChannelId) === false) {
            return;
        }

        $page = $event->getPage();
        $cmsPage = $page->getCmsPage();
        if ($cmsPage === null) {
            return;
        }

        $product = $page->getProduct();
        $ids = array_filter([$product->getId(), $product->getParentId()]);

        foreach ($cmsPage->getElementsOfType('product-slider') as $slot) {
            $data = $slot->getData();
            if (!$data instanceof ProductSliderStruct) {
                continue;
            }
            $products = $data->getProducts();
            if ($products === null) {
                continue;
            }
            foreach ($ids as $id) {
                $products->remove($id);
            }
        }
    }
}
