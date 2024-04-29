<?php

declare(strict_types=1);

namespace Oneup\ContaoSentryBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OneupContaoSentryBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
