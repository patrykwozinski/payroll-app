<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Domain\AggregateRoot;
use App\Payroll\Domain\Event\WorkerHired;

final class Worker extends AggregateRoot
{
    private WorkerId $id;
    private PersonalData $personalData;
    private Department $department;
    private Seniority $seniority;
    private Salary $salary;

    public function __construct(WorkerId $id, PersonalData $personalData, Department $department, Seniority $seniority, Salary $salary)
    {
        $this->id = $id;
        $this->personalData = $personalData;
        $this->department = $department;
        $this->seniority = $seniority;
        $this->salary = $salary;
    }

    public static function hire(WorkerId $id, PersonalData $personalData, Department $department, Seniority $seniority, Salary $salary): self
    {
        $worker = new self($id, $personalData, $department, $seniority, $salary);
        $worker->recordThat(new WorkerHired($id));

        return $worker;
    }
}
