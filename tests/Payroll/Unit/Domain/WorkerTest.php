<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain;

use App\Payroll\Domain\BonusSalary;
use App\Payroll\Domain\Event\BonusSalaryRecalculated;
use App\Payroll\Domain\Event\WorkerHired;
use App\Payroll\Domain\Worker;
use App\Payroll\Domain\WorkerId;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use App\Tests\Payroll\ObjectMother\Domain\PersonalDataMother;
use App\Tests\Payroll\ObjectMother\Domain\SalaryMother;
use App\Tests\Payroll\ObjectMother\Domain\SeniorityMother;
use App\Tests\Payroll\ObjectMother\Domain\WorkerMother;
use App\Tests\Payroll\TestDouble\AlwaysSameBonusSalaryRule;
use PHPUnit\Framework\TestCase;

final class WorkerTest extends TestCase
{
    public function testWorkerSuccessfullyHired(): void
    {
        // Arrange
        $id = WorkerId::random();
        $personalData = PersonalDataMother::random();
        $department = DepartmentMother::random();
        $seniority = SeniorityMother::random();
        $salary = SalaryMother::random();

        // Act
        $worker = Worker::hire($id, $personalData, $department, $seniority, $salary);

        // Assert
        $recordedEvent = $worker->pullEvents()[0];
        $expectedEvent = new WorkerHired($id);
        self::assertEquals($expectedEvent, $recordedEvent, 'Worker should be hired');
    }

    public function testBonusSalaryRecalculated(): void
    {
        // Arrange
        $id = WorkerId::random();
        $bonusSalary = BonusSalary::starting();
        $worker = WorkerMother::withIdAndBonus($id, $bonusSalary);
        $rule = new AlwaysSameBonusSalaryRule();

        // Act
        $worker->recalculateBonusSalary($rule);

        // Assert
        $recordedEvent = $worker->pullEvents()[0];
        $expectedEvent = new BonusSalaryRecalculated($id, $bonusSalary, $bonusSalary);
        self::assertEquals($expectedEvent, $recordedEvent);
    }
}
