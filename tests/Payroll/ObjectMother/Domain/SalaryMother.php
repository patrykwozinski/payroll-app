<?php

declare(strict_types=1);

namespace App\Tests\Payroll\ObjectMother\Domain;

use App\Payroll\Domain\Salary;

final class SalaryMother
{
    public static function random(): Salary
    {
        return new Salary(5000);
    }
}
