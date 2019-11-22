<?php

declare(strict_types=1);

namespace Oneup\Contao\SentryBundle\Twig;

use Raven_Client;

class ContaoSentryTwigRuntime
{
    /**
     * @var Raven_Client
     */
    private $client;

    /**
     * AppRuntime constructor.
     *
     * @param Raven_Client $client
     */
    public function __construct(Raven_Client $client)
    {
        $this->client = $client;
    }

    /**
     * Return the last captured event's ID or null if none available.
     *
     * @return string|null
     */
    public function sentryLastEventIdFilter(): ?string
    {
        return $this->client->getLastEventID();
    }

    /**
     * Return the Sentry DSN. The DSN gets disassembled in the Raven_Client, so we build it here again.
     *
     * @return string
     */
    public function sentryDsn(): string
    {
        return sprintf('https://'.$this->client->public_key.'@sentry.io/'.$this->client->project);
    }
}
