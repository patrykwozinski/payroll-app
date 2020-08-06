<?php

declare(strict_types=1);

namespace App\Common;

use DateTimeImmutable;

final class Date
{
    private DateTimeImmutable $dateTime;

    public function __construct(DateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function diffInYears(Date $hiredAt): int
    {
        return $this->dateTime->diff($hiredAt->dateTime)->y;
    }

    public function __toString(): string
    {
        return $this->dateTime->format('Y-m-d');
    }
}
