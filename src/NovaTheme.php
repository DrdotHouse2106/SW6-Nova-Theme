<?php declare(strict_types=1);

namespace Nova\NovaTheme;

use Nova\NovaTheme\Gpsr\GpsrCustomFields;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;
use Shopware\Storefront\Framework\ThemeInterface;

/**
 * Nova Theme – modernes, modulares und performantes Storefront-Theme.
 */
class NovaTheme extends Plugin implements ThemeInterface
{
    public function install(InstallContext $installContext): void
    {
        parent::install($installContext);
        $this->gpsrFields()?->install($installContext->getContext());
    }

    public function update(UpdateContext $updateContext): void
    {
        parent::update($updateContext);
        $this->gpsrFields()?->install($updateContext->getContext());
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);
        if ($uninstallContext->keepUserData()) {
            return;
        }
        $this->gpsrFields()?->uninstall($uninstallContext->getContext());
    }

    private function gpsrFields(): ?GpsrCustomFields
    {
        $repository = $this->container?->get('custom_field_set.repository');

        return $repository instanceof EntityRepository ? new GpsrCustomFields($repository) : null;
    }
}
