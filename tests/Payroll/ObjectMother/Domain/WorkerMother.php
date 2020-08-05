<?php

declare(strict_types=1);

namespace App\Tests\Payroll\ObjectMother\Domain;

use App\Payroll\Domain\BonusSalary;
use App\Payroll\Domain\Worker;
use App\Payroll\Domain\WorkerId;

final class WorkerMother
{
    public static function withIdAndBonus(WorkerId $id, BonusSalary $bonusSalary): Worker
    {
        return new Worker(
            $id,
            PersonalDataMother::random(),
            DepartmentMother::random(),
            SeniorityMother::random(),
            SalaryMother::random(),
            $bonusSalary
        );
    }
}
