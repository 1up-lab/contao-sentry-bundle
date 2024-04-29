<?php

declare(strict_types=1);

namespace Oneup\ContaoSentryBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Oneup\ContaoSentryBundle\OneupContaoSentryBundle;
use Sentry\SentryBundle\SentryBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

class Plugin implements BundlePluginInterface, ConfigPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(SentryBundle::class),
            BundleConfig::create(OneupContaoSentryBundle::class)->setLoadAfter([
                ContaoCoreBundle::class,
                SentryBundle::class,
            ]),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig): void
    {
        $loader->load(__DIR__.'/../../config/skeleton.yaml');
    }
}
