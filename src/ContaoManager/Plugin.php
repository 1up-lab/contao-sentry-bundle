<?php

declare(strict_types=1);

namespace Oneup\ContaoSentryBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Oneup\ContaoSentryBundle\OneupContaoSentryBundle;
use Sentry\SentryBundle\SentryBundle;

class Plugin implements BundlePluginInterface
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
}
