<?php

declare(strict_types=1);

namespace App\Tests\Payroll\ObjectMother\Domain;

use App\Payroll\Domain\Money;

final class MoneyMother
{
    public const DEFAULT = 5000;

    public static function random(): Money
    {
        return new Money(self::DEFAULT);
    }
}
