<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Domain\AggregateRoot;
use App\Payroll\Domain\Event\BonusSalaryRecalculated;
use App\Payroll\Domain\Event\WorkerHired;
use App\Payroll\Domain\Policy\BonusSalaryRule;

final class Worker extends AggregateRoot
{
    private WorkerId $id;
    private PersonalData $personalData;
    private Department $department;
    private Seniority $seniority;
    private Salary $salary;
    private BonusSalary $bonusSalary;

    public function __construct(WorkerId $id, PersonalData $personalData, Department $department, Seniority $seniority, Salary $salary, BonusSalary $bonusSalary)
    {
        $this->id = $id;
        $this->personalData = $personalData;
        $this->department = $department;
        $this->seniority = $seniority;
        $this->salary = $salary;
        $this->bonusSalary = $bonusSalary;
    }

    public static function hire(WorkerId $id, PersonalData $personalData, Department $department, Seniority $seniority, Salary $salary): self
    {
        $worker = new self($id, $personalData, $department, $seniority, $salary, BonusSalary::starting());
        $worker->recordThat(new WorkerHired($id));

        return $worker;
    }

    public function recalculateBonusSalary(BonusSalaryRule $rule): void
    {
        $this->bonusSalary = $rule->calculate($this->bonusSalary, $this->department, $this->seniority);

        $this->recordThat(new BonusSalaryRecalculated($this->id, $this->bonusSalary, $this->bonusSalary));
    }
}
