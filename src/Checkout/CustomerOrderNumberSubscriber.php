<?php declare(strict_types=1);

namespace Nova\NovaTheme\Checkout;

use Shopware\Core\Checkout\Cart\Order\CartConvertedEvent;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Feld „Ihre Bestellnummer“ in der Kasse: Wert landet als Zusatzfeld nova_customer_order_number an der Bestellung
 * und vorne im Kundenkommentar („Ihre Bestellnummer: …“), damit er auch in Warenwirtschaft und Lieferschein ankommt.
 */
class CustomerOrderNumberSubscriber implements EventSubscriberInterface
{
    public const FIELD = 'nova_customer_order_number';
    public const REQUEST_KEY = 'novaCustomerOrderNumber';
    private const MAX_LENGTH = 50;

    public function __construct(
        private readonly SystemConfigService $config,
        private readonly RequestStack $requestStack,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [CartConvertedEvent::class => 'onCartConverted'];
    }

    public function onCartConverted(CartConvertedEvent $event): void
    {
        $scId = $event->getSalesChannelContext()->getSalesChannelId();
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null || !$this->config->getBool('NovaTheme.config.customerOrderNumber', $scId)) {
            return;
        }
        $number = self::clean((string) $request->request->get(self::REQUEST_KEY, ''));
        if ($number === '') {
            return;
        }
        $order = $event->getConvertedCart();
        $order['customFields'] = array_merge($order['customFields'] ?? [], [self::FIELD => $number]);
        $comment = trim((string) ($order['customerComment'] ?? ''));
        $order['customerComment'] = 'Ihre Bestellnummer: ' . $number . ($comment !== '' ? "\n\n" . $comment : '');
        $event->setConvertedCart($order);
    }

    public static function clean(string $value): string
    {
        $value = trim((string) preg_replace('/\s+/u', ' ', strip_tags($value)));

        return mb_substr($value, 0, self::MAX_LENGTH);
    }
}
