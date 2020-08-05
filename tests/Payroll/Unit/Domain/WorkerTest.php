<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain;

use App\Payroll\Domain\Event\WorkerHired;
use App\Payroll\Domain\Worker;
use App\Payroll\Domain\WorkerId;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use App\Tests\Payroll\ObjectMother\Domain\PersonalDataMother;
use App\Tests\Payroll\ObjectMother\Domain\SalaryMother;
use App\Tests\Payroll\ObjectMother\Domain\SeniorityMother;
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
}
