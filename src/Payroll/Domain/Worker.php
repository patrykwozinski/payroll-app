<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Date;
use App\Common\Domain\AggregateRoot;
use App\Common\Domain\Clock;
use App\Payroll\Domain\Event\WorkerHired;

final class Worker extends AggregateRoot
{
    private WorkerId $id;
    private PersonalData $personalData;
    private Department $department;
    private Salary $salary;
    private Date $hiredAt;

    public function __construct(WorkerId $id, PersonalData $personalData, Department $department, Salary $salary, Date $hiredAt)
    {
        $this->id = $id;
        $this->personalData = $personalData;
        $this->department = $department;
        $this->salary = $salary;
        $this->hiredAt = $hiredAt;
    }

    public static function hire(WorkerId $id, PersonalData $personalData, Department $department, Salary $salary, Clock $clock): self
    {
        $hiredAt = $clock->now();

        $worker = new self($id, $personalData, $department, $salary, $hiredAt);
        $worker->recordThat(new WorkerHired($id));

        return $worker;
    }
}
