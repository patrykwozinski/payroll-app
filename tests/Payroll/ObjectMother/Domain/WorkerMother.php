<?php

declare(strict_types=1);

namespace App\Tests\Payroll\ObjectMother\Domain;

use App\Common\Calendar\Date;
use App\Payroll\Domain\Department;
use App\Payroll\Domain\Money;
use App\Payroll\Domain\PersonalData;
use App\Payroll\Domain\Worker;
use App\Payroll\Domain\WorkerId;
use App\Tests\Common\TestDouble\StubClock;
use DateTimeImmutable;

final class WorkerMother
{
    private WorkerId $id;
    private Department $department;
    private PersonalData $personalData;
    private Money $salary;
    private Date $hiredAt;

    private function __construct()
    {
        $expectedDate = new Date(new DateTimeImmutable('2020-01-01 00:00'));

        $this->id = WorkerId::random();
        $this->department = DepartmentMother::random();
        $this->personalData = PersonalDataMother::random();
        $this->salary = MoneyMother::random();
        $this->hiredAt = StubClock::markFixed($expectedDate)->now();
    }

    public static function make(): self
    {
        return new self();
    }

    public function withDepartment(Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function withSalary(Money $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function withHiredAt(Date $hiredAt): self
    {
        $this->hiredAt = $hiredAt;

        return $this;
    }

    public function build(): Worker
    {
        return new Worker(
            $this->id,
            $this->personalData,
            $this->department,
            $this->salary,
            $this->hiredAt
        );
    }
}
