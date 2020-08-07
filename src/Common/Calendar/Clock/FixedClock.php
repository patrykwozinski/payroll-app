<?php

declare(strict_types=1);

namespace App\Common\Calendar\Clock;

use App\Common\Calendar\Clock;
use App\Common\Calendar\Date;

final class FixedClock implements Clock
{
    private Date $expectedDate;

    private function __construct(Date $expectedDate)
    {
        $this->expectedDate = $expectedDate;
    }

    public static function on(Date $fixedDate): self
    {
        return new self($fixedDate);
    }

    public function now(): Date
    {
        return $this->expectedDate;
    }
}
