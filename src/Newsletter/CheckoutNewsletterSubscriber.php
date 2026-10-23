<?php declare(strict_types=1);

namespace Nova\NovaTheme\Newsletter;

use Psr\Log\LoggerInterface;
use Shopware\Core\Checkout\Cart\Event\CheckoutOrderPlacedEvent;
use Shopware\Core\Content\Newsletter\SalesChannel\AbstractNewsletterSubscribeRoute;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Struct\ArrayStruct;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\SalesChannelRequest;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Page\Checkout\Confirm\CheckoutConfirmPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Newsletter-Häkchen in der Bestellübersicht.
 *
 * Bestellübersicht: prüft, ob die E-Mail des Kunden schon angemeldet ist – dann wird kein Häkchen gezeigt.
 * Bestellung: Ist das Häkchen gesetzt, meldet Shopwares eigene Newsletter-Anmeldung die Bestell-E-Mail an
 * (mit Double-Opt-in gemäß Shopware-Einstellung). Ein Fehler dabei bricht die Bestellung nie ab.
 */
class CheckoutNewsletterSubscriber implements EventSubscriberInterface
{
    public const FIELD = 'novaNewsletter';
    public const EXTENSION = 'novaNewsletter';

    /**
     * @param EntityRepository<\Shopware\Core\Content\Newsletter\Aggregate\NewsletterRecipient\NewsletterRecipientCollection> $recipientRepository
     */
    public function __construct(
        private readonly SystemConfigService $config,
        private readonly EntityRepository $recipientRepository,
        private readonly AbstractNewsletterSubscribeRoute $subscribeRoute,
        private readonly RequestStack $requestStack,
        private readonly LoggerInterface $logger,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CheckoutConfirmPageLoadedEvent::class => 'onConfirmPage',
            CheckoutOrderPlacedEvent::class => 'onOrderPlaced',
        ];
    }

    public function onConfirmPage(CheckoutConfirmPageLoadedEvent $event): void
    {
        $context = $event->getSalesChannelContext();
        if (!$this->isActive($context->getSalesChannelId())) {
            return;
        }

        $email = $context->getCustomer()?->getEmail();
        $subscribed = $email !== null && $this->isSubscribed($email, $context);

        $event->getPage()->addExtension(self::EXTENSION, new ArrayStruct(['show' => !$subscribed]));
    }

    public function onOrderPlaced(CheckoutOrderPlacedEvent $event): void
    {
        $request = $this->requestStack->getMainRequest();
        if ($request === null || !$request->request->getBoolean(self::FIELD)) {
            return;
        }

        $context = $event->getSalesChannelContext();
        if (!$this->isActive($context->getSalesChannelId())) {
            return;
        }

        $customer = $event->getOrder()->getOrderCustomer();
        if ($customer === null || $customer->getEmail() === '') {
            return;
        }

        $data = new RequestDataBag([
            'email' => $customer->getEmail(),
            'option' => 'subscribe',
            'salutationId' => $customer->getSalutationId(),
            'firstName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'storefrontUrl' => (string) $request->attributes->get(SalesChannelRequest::ATTRIBUTE_STOREFRONT_URL, ''),
        ]);

        try {
            // ab Shopware 6.7 subscribeWithResponse(), davor subscribe()
            // @phpstan-ignore function.alreadyNarrowedType (Shopware 6.6 kennt die Methode noch nicht)
            if (method_exists($this->subscribeRoute, 'subscribeWithResponse')) {
                $this->subscribeRoute->subscribeWithResponse($data, $context, false);
            } else {
                $this->subscribeRoute->subscribe($data, $context, false);
            }
        } catch (\Throwable $e) {
            $this->logger->warning('Nova Theme: Newsletter-Anmeldung bei Bestellung fehlgeschlagen', [
                'order' => $event->getOrder()->getOrderNumber(),
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function isActive(string $salesChannelId): bool
    {
        return $this->config->getBool('NovaTheme.config.newsletterCheckout', $salesChannelId);
    }

    private function isSubscribed(string $email, SalesChannelContext $context): bool
    {
        $criteria = (new Criteria())
            ->addFilter(new EqualsFilter('email', $email))
            ->addFilter(new EqualsFilter('salesChannelId', $context->getSalesChannelId()))
            ->addFilter(new EqualsAnyFilter('status', ['optIn', 'direct']))
            ->setLimit(1);

        return $this->recipientRepository->searchIds($criteria, $context->getContext())->getTotal() > 0;
    }
}
