<?php

declare(strict_types=1);

namespace Oneup\Contao\SentryBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Dependency\DependentPluginInterface;
use Oneup\Contao\SentryBundle\OneupContaoSentryBundle;
use Sentry\SentryBundle\SentryBundle;

class Plugin implements BundlePluginInterface, DependentPluginInterface
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

    public function getPackageDependencies(): array
    {
        return [
            'sentry/sentry-symfony',
        ];
    }
}
