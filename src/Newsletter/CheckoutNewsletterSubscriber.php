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
use Shopware\Storefront\Page\Checkout\Finish\CheckoutFinishPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Newsletter-Anmeldung im Bestellprozess – wahlweise
 * - „finish“: Kasten auf der Bestellabschlussseite (nach der Bestellung, Formular an /form/newsletter) oder
 * - „confirm“: Häkchen in der Bestellübersicht; ist es gesetzt, meldet Shopwares Newsletter-Anmeldung die
 *   Bestell-E-Mail an. Ein Fehler dabei bricht die Bestellung nie ab.
 *
 * In beiden Fällen wird nichts gezeigt, wenn die E-Mail schon angemeldet ist. Double-Opt-in gemäß Shopware-Einstellung.
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
            CheckoutFinishPageLoadedEvent::class => 'onFinishPage',
            CheckoutOrderPlacedEvent::class => 'onOrderPlaced',
        ];
    }

    public function onConfirmPage(CheckoutConfirmPageLoadedEvent $event): void
    {
        $context = $event->getSalesChannelContext();
        if (!$this->isActive($context->getSalesChannelId(), 'confirm')) {
            return;
        }

        $email = $context->getCustomer()?->getEmail();
        $subscribed = $email !== null && $this->isSubscribed($email, $context);

        $event->getPage()->addExtension(self::EXTENSION, new ArrayStruct(['show' => !$subscribed]));
    }

    public function onFinishPage(CheckoutFinishPageLoadedEvent $event): void
    {
        $context = $event->getSalesChannelContext();
        if (!$this->isActive($context->getSalesChannelId(), 'finish')) {
            return;
        }

        $email = $event->getPage()->getOrder()->getOrderCustomer()?->getEmail() ?? '';
        if ($email === '' || $this->isSubscribed($email, $context)) {
            return;
        }

        $event->getPage()->addExtension(self::EXTENSION, new ArrayStruct(['show' => true, 'email' => $email]));
    }

    public function onOrderPlaced(CheckoutOrderPlacedEvent $event): void
    {
        $request = $this->requestStack->getMainRequest();
        if ($request === null || !$request->request->getBoolean(self::FIELD)) {
            return;
        }

        $context = $event->getSalesChannelContext();
        if (!$this->isActive($context->getSalesChannelId(), 'confirm')) {
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

    private function isActive(string $salesChannelId, string $position): bool
    {
        if (!$this->config->getBool('NovaTheme.config.newsletterCheckout', $salesChannelId)) {
            return false;
        }

        $configured = $this->config->getString('NovaTheme.config.newsletterCheckoutPosition', $salesChannelId);

        return ($configured !== '' ? $configured : 'finish') === $position;
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
