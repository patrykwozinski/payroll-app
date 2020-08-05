<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Domain\AggregateRoot;
use App\Payroll\Domain\Event\WorkerHired;

final class Worker extends AggregateRoot
{
    private WorkerId $id;
    private string $firstName;
    private string $lastName;
    /** @var Department */
    private Department $department;
    /** @var Seniority */
    private Seniority $seniority;
    /** @var Salary */
    private Salary $salary;

    public function __construct(WorkerId $id, string $firstName, string $lastName, Department $department, Seniority $seniority, Salary $salary) // SPOKO MAM SZEROKI MONITOR :P
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->department = $department;
        $this->seniority = $seniority;
        $this->salary = $salary;
    }

    public static function hire(WorkerId $id, string $firstName, string $lastName, Department $department, Seniority $seniority, Salary $salary): self
    {
        $worker = new self($id, $firstName, $lastName, $department, $seniority, $salary);
        $worker->recordThat(new WorkerHired($id));

        return $worker;
    }
}
