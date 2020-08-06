<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class WorkerSnapshot
{
    private WorkerId $workerId;
    private PersonalData $personalData;
    private Department $department;
    private Money $salary;

    public function __construct(WorkerId $workerId, PersonalData $personalData, Department $department, Money $salary)
    {
        $this->workerId = $workerId;
        $this->personalData = $personalData;
        $this->department = $department;
        $this->salary = $salary;
    }
}
