<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain;

use App\Common\Date;
use App\Tests\Common\TestDouble\Domain\StubClock;
use App\Payroll\Domain\Event\WorkerHired;
use App\Payroll\Domain\Worker;
use App\Payroll\Domain\WorkerId;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use App\Tests\Payroll\ObjectMother\Domain\PersonalDataMother;
use App\Tests\Payroll\ObjectMother\Domain\SalaryMother;
use PHPUnit\Framework\TestCase;

final class WorkerTest extends TestCase
{
    public function testWorkerSuccessfullyHired(): void
    {
        // Arrange
        $id = WorkerId::random();
        $personalData = PersonalDataMother::random();
        $department = DepartmentMother::random();
        $salary = SalaryMother::random();
        $expectedDate = new Date(new \DateTimeImmutable('2020-02-02 12:30:00'));
        $clock = StubClock::markFixed($expectedDate);

        // Act
        $worker = Worker::hire($id, $personalData, $department, $salary, $clock);

        // Assert
        $recordedEvent = $worker->pullEvents()[0];
        $expectedEvent = new WorkerHired($id);
        self::assertEquals($expectedEvent, $recordedEvent, 'Worker should be hired');
    }
}
