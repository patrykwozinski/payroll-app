<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class WorkerSnapshot
{
    private WorkerId $id;
    private PersonalData $personalData;
    private Department $department;
    private Money $salary;

    public function __construct(WorkerId $id, PersonalData $personalData, Department $department, Money $salary)
    {
        $this->id = $id;
        $this->personalData = $personalData;
        $this->department = $department;
        $this->salary = $salary;
    }
}
