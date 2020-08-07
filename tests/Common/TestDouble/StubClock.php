<?php

declare(strict_types=1);

namespace App\Tests\Common\TestDouble;

use App\Common\Calendar\Clock;
use App\Common\Calendar\Date;

final class StubClock implements Clock
{
    private Date $expectedDate;

    private function __construct(Date $expectedDate)
    {
        $this->expectedDate = $expectedDate;
    }

    public static function markFixed(Date $expectedDate): self
    {
        return new self($expectedDate);
    }

    public function now(): Date
    {
        return $this->expectedDate;
    }
}
