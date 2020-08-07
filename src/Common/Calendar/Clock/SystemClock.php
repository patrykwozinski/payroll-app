<?php

declare(strict_types=1);

namespace App\Common\Calendar\Clock;

use App\Common\Calendar\Clock;
use App\Common\Calendar\Date;
use DateTimeImmutable;

final class SystemClock implements Clock
{
    public function now(): Date
    {
        $now = new DateTimeImmutable('now');

        return new Date($now);
    }
}
