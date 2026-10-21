<?php declare(strict_types=1);

namespace Nova\NovaTheme\Controller;

use Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Content\Product\SalesChannel\ProductAvailableFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\PlatformRequest;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepository;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Storefront\Framework\Routing\StorefrontRouteScope;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Liefert die Liste „Zuletzt angesehen“ als HTML-Fragment.
 *
 * Die Produkt-IDs kommen aus dem Browser (localStorage) – der Server speichert nichts.
 * Die Antwort hängt nur von den IDs ab und ist daher per HTTP-Cache cachebar.
 */
#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StorefrontRouteScope::ID]])]
class RecentlyViewedController extends StorefrontController
{
    private const MAX_PRODUCTS = 20;

    /**
     * @param SalesChannelRepository<ProductCollection> $productRepository
     */
    public function __construct(private readonly SalesChannelRepository $productRepository)
    {
    }

    #[Route(
        path: '/nova/recently-viewed',
        name: 'frontend.nova.recently-viewed',
        defaults: ['XmlHttpRequest' => true, PlatformRequest::ATTRIBUTE_HTTP_CACHE => true],
        methods: [Request::METHOD_GET]
    )]
    public function list(Request $request, SalesChannelContext $context): Response
    {
        // Nur gültige IDs (32 Hex-Zeichen), ohne Duplikate, Reihenfolge beibehalten
        $ids = array_values(array_unique(array_filter(
            explode('|', (string) $request->query->get('ids', '')),
            static fn (string $id): bool => preg_match('/^[0-9a-f]{32}$/', $id) === 1
        )));
        $ids = \array_slice($ids, 0, self::MAX_PRODUCTS);

        $products = [];
        if ($ids !== []) {
            $criteria = new Criteria($ids);
            $criteria->setTitle('nova-theme::recently-viewed');
            $criteria->addAssociation('cover.media');
            $criteria->addAssociation('manufacturer');
            $criteria->addFilter(new ProductAvailableFilter($context->getSalesChannelId(), ProductVisibilityDefinition::VISIBILITY_ALL));

            $found = $this->productRepository->search($criteria, $context)->getEntities();

            // Reihenfolge wie im Browser gespeichert (neueste zuerst)
            foreach ($ids as $id) {
                $product = $found->get($id);
                if ($product !== null) {
                    $products[] = $product;
                }
            }
        }

        $response = $this->renderStorefront('@NovaTheme/storefront/nova/recently-viewed.html.twig', [
            'products' => $products,
        ]);
        $response->headers->set('x-robots-tag', 'noindex');

        return $response;
    }
}
