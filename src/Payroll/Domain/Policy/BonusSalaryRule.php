<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Policy;

use App\Payroll\Domain\BonusSalary;
use App\Payroll\Domain\Department;
use App\Payroll\Domain\Seniority;

interface BonusSalaryRule
{
    public function calculate(BonusSalary $currentBonus, Department $department, Seniority $seniority): BonusSalary;
}
