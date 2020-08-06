<?php

declare(strict_types=1);

namespace App\Tests\Common\TestDouble\Domain;

use App\Common\Date;
use App\Common\Domain\Clock;

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
