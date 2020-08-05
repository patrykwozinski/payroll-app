<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class Salary
{
    private int $money;

    public function __construct(int $money)
    {
        $this->money = $money;
    }
}
