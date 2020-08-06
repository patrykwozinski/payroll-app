<?php

declare(strict_types=1);

namespace App\Common\Domain\Clock;

use App\Common\Date;
use App\Common\Domain\Clock;
use DateTimeImmutable;

final class SystemClock implements Clock
{
    public function now(): Date
    {
        $now = new DateTimeImmutable('now');

        return new Date($now);
    }
}
