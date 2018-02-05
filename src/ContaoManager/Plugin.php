<?php

declare(strict_types=1);

namespace Oneup\Contao\SentryBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Contao\ManagerPlugin\Dependency\DependentPluginInterface;
use Oneup\Contao\SentryBundle\OneupContaoSentryBundle;
use Sentry\SentryBundle\SentryBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

class Plugin implements BundlePluginInterface, ConfigPluginInterface, DependentPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            // load SentryBundle (dependency)
            BundleConfig::create(SentryBundle::class)->setLoadAfter([ContaoCoreBundle::class]),

            // load OneupContaoSentryBundle
            BundleConfig::create(OneupContaoSentryBundle::class)->setLoadAfter([
                ContaoCoreBundle::class,
                SentryBundle::class,
            ]),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig): void
    {
        // load default config from SentryBundle
        $loader->load('@SentryBundle/Resources/config/services.yml');
    }

    public function getPackageDependencies(): array
    {
        return [
            'sentry/sentry-symfony',
        ];
    }
}
