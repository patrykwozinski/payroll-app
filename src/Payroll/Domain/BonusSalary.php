<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class BonusSalary
{
    private int $money;

    public function __construct(int $money)
    {
        $this->money = $money;
    }

    public static function starting(): self
    {
        return new self(0);
    }
}
