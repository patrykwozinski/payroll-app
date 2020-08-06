<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Date;
use App\Common\Domain\AggregateRoot;
use App\Payroll\Domain\Event\WorkerHired;

final class Worker extends AggregateRoot
{
    private WorkerId $id;
    private PersonalData $personalData;
    private Department $department;
    private Money $salary;
    private Date $hiredAt;

    public function __construct(WorkerId $id, PersonalData $personalData, Department $department, Money $salary, Date $hiredAt)
    {
        $this->id = $id;
        $this->personalData = $personalData;
        $this->department = $department;
        $this->salary = $salary;
        $this->hiredAt = $hiredAt;
    }

    public static function hire(WorkerId $id, PersonalData $personalData, Department $department, Money $salary, Date $hiredAt): self
    {
        $worker = new self($id, $personalData, $department, $salary, $hiredAt);
        $worker->recordThat(new WorkerHired($id));

        return $worker;
    }

    public function id(): WorkerId
    {
        return $this->id;
    }

    public function salaryBonus(BonusCalculator ...$bonusCalculators): Money
    {
        $bonusType = $this->department->bonusType();

        foreach ($bonusCalculators as $calculator) {
            if ($calculator->supports($bonusType)) {
                return $calculator->calculate($this->salary, $bonusType, $this->hiredAt);
            }
        }

        return Money::zero();
    }

    public function snapshot(): WorkerSnapshot
    {
        return new WorkerSnapshot(
            $this->id,
            $this->personalData,
            $this->department,
            $this->salary
        );
    }
}
