<?php

declare(strict_types=1);

namespace App\Tests\Payroll\TestDouble;

use App\Payroll\Domain\BonusSalary;
use App\Payroll\Domain\Department;
use App\Payroll\Domain\Policy\BonusSalaryRule;
use App\Payroll\Domain\Seniority;

final class AlwaysSameBonusSalaryRule implements BonusSalaryRule
{
    public function calculate(BonusSalary $currentBonus, Department $department, Seniority $seniority): BonusSalary
    {
        return $currentBonus;
    }
}
