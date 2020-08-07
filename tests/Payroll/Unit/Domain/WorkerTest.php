<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain;

use App\Common\Calendar\Date;
use App\Payroll\Domain\BonusCalculator\PercentageBonusCalculator;
use App\Payroll\Domain\BonusCalculator\YearlyBonusCalculator;
use App\Payroll\Domain\Money;
use App\Payroll\Domain\Worker;
use App\Payroll\Domain\WorkerId;
use App\Tests\Common\TestDouble\StubClock;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use App\Tests\Payroll\ObjectMother\Domain\MoneyMother;
use App\Tests\Payroll\ObjectMother\Domain\PersonalDataMother;
use App\Tests\Payroll\ObjectMother\Domain\WorkerMother;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class WorkerTest extends TestCase
{
    public function testWorkerSuccessfullyHired(): void
    {
        // Given
        $id = WorkerId::random();
        $personalData = PersonalDataMother::random();
        $department = DepartmentMother::random();
        $salary = MoneyMother::random();
        $expectedDate = new Date(new DateTimeImmutable('2020-02-02 12:30:00'));
        $clock = StubClock::markFixed($expectedDate);

        // When
        $worker = Worker::hire($id, $personalData, $department, $salary, $clock->now());

        // Then
        self::assertEquals($id, $worker->id(), 'Worker should be hired');
    }

    public function testSalaryBonusIsZeroWhenNoCalculators(): void
    {
        // Given
        $worker = WorkerMother::make()->build();

        // When
        $salaryBonus = $worker->salaryBonus();

        // Then
        self::assertTrue($salaryBonus->equals(Money::zero()), 'Without calculator bonus should be equal to zero');
    }

    public function testSalaryBonusIsPercentOfBaseSalary(): void
    {
        // Given
        $worker = WorkerMother::make()
            ->withSalary(new Money(1000))
            ->withDepartment(DepartmentMother::withPercentageBonus(10))
            ->build();
        $percentageCalculator = new PercentageBonusCalculator();
        $expectedBonus = new Money(100);

        // When
        $salaryBonus = $worker->salaryBonus($percentageCalculator);

        // Then
        self::assertTrue($salaryBonus->equals($expectedBonus), 'Bonus should be 10% more than 1000 base salary');
    }

    public function testSalaryBonusIsThreeYearsWhenHiredThreeYearsAgo(): void
    {
        // Given
        $now = new Date(new DateTimeImmutable('2013-01-01'));
        $afterYearsClock = StubClock::markFixed($now);

        $hiredAt = new Date(new DateTimeImmutable('2010-01-01'));
        $worker = WorkerMother::make()
            ->withSalary(new Money(1000))
            ->withDepartment(DepartmentMother::withYearlyBonus(100))
            ->withHiredAt($hiredAt)
            ->build();
        $percentageCalculator = new YearlyBonusCalculator($afterYearsClock);
        $expectedBonus = new Money(300);

        // When
        $salaryBonus = $worker->salaryBonus($percentageCalculator);

        // Then
        self::assertTrue($salaryBonus->equals($expectedBonus), 'Bonus should be 3x yearly bonus (100*3)');
    }
}
