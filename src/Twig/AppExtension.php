<?php

declare(strict_types=1);

namespace Oneup\Contao\SentryBundle\Twig;

use Twig_Extension;
use Twig_Filter;
use Twig_SimpleFilter;

class AppExtension extends Twig_Extension
{

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return Twig_Filter[]
     */
    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter('sentry_last_event_id', [AppRuntime::class, 'sentryLastEventIdFilter']),
            new Twig_SimpleFilter('sentry_dsn', [AppRuntime::class, 'sentryDsn']),
        ];
    }
}
