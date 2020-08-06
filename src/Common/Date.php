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
}
