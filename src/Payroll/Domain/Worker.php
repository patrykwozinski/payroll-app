<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Calendar\Date;

final class Worker
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
        return new self($id, $personalData, $department, $salary, $hiredAt);
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

    public function personalData(): PersonalData
    {
        return $this->personalData;
    }

    public function department(): Department
    {
        return $this->department;
    }

    public function salary(): Money
    {
        return $this->salary;
    }
}
