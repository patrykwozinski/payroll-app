<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use Webmozart\Assert\Assert;

final class Salary
{
    private int $money;

    public function __construct(int $money)
    {
        Assert::greaterThan($money, 'Salary can not be less or equals to zero');

        $this->money = $money;
    }
}
