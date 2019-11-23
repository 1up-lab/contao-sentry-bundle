<?php

declare(strict_types=1);

namespace Oneup\Contao\SentryBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ContaoSentryTwigExtension extends AbstractExtension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('sentry_last_event_id', [ContaoSentryTwigRuntime::class, 'sentryLastEventIdFilter']),
            new TwigFilter('sentry_dsn', [ContaoSentryTwigRuntime::class, 'sentryDsn']),
        ];
    }
}
