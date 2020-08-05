<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

interface BonusSalaryRule
{
    public function calculate(BonusSalary $currentBonus, Department $department, Seniority $seniority): BonusSalary;
}
