<?php declare(strict_types=1);

namespace Nova\NovaTheme\Cookie;

use Shopware\Core\Content\Cookie\Event\CookieGroupCollectEvent;
use Shopware\Core\Content\Cookie\Service\CookieProvider;
use Shopware\Core\Content\Cookie\Struct\CookieEntry;
use Shopware\Core\Content\Cookie\Struct\CookieEntryCollection;
use Shopware\Core\System\SystemConfig\SystemConfigService;

/**
 * Trägt „Zuletzt angesehen“ in die Cookie-Gruppe „Komfortfunktionen“ ein.
 * Die Liste wird nur geführt und angezeigt, wenn der Kunde zugestimmt hat.
 *
 * Gleicher Cookie-Name wie im Plugin „Nova Suche“ – Shopware führt gleichnamige
 * Einträge zusammen, der Eintrag erscheint also nur einmal im Cookie-Dialog.
 */
class RecentlyViewedCookieListener
{
    public const COOKIE = 'nova-recently-viewed';

    public function __construct(private readonly SystemConfigService $config)
    {
    }

    public function __invoke(CookieGroupCollectEvent $event): void
    {
        $salesChannelId = $event->getSalesChannelContext()->getSalesChannelId();
        if ($this->config->get('NovaTheme.config.recentlyViewed', $salesChannelId) === false) {
            return;
        }

        $group = $event->cookieGroupCollection->get(CookieProvider::SNIPPET_NAME_COOKIE_GROUP_COMFORT_FEATURES);
        if ($group === null) {
            return;
        }

        $entries = $group->getEntries();
        if ($entries === null) {
            $entries = new CookieEntryCollection();
            $group->setEntries($entries);
        }

        $entry = new CookieEntry(self::COOKIE);
        $entry->name = 'novaTheme.cookie.recentlyViewed';
        $entry->value = '1';
        $entry->expiration = 30;
        $entries->add($entry);
    }
}
