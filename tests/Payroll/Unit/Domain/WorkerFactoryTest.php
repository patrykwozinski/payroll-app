<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain;

use App\Common\Date;
use App\Payroll\Domain\DepartmentId;
use App\Payroll\Domain\Error\DepartmentNotFound;
use App\Payroll\Domain\WorkerFactory;
use App\Payroll\Domain\WorkerId;
use App\Tests\Common\TestDouble\Domain\StubClock;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use App\Tests\Payroll\TestDouble\Domain\NotFoundDepartments;
use App\Tests\Payroll\TestDouble\Domain\StubDepartments;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class WorkerFactoryTest extends TestCase
{
    private StubClock $clock;
    private WorkerId $workerId;
    private DepartmentId $departmentId;
    private string $firstName;
    private string $lastName;
    private int $salary;

    protected function setUp(): void
    {
        // Background
        $expectedDate = new Date(new DateTimeImmutable('2019-02-02 21:37:00'));
        $this->clock = StubClock::markFixed($expectedDate);
        $this->workerId = WorkerId::random();
        $this->departmentId = DepartmentId::fromString(DepartmentMother::ID);
        $this->firstName = 'John';
        $this->lastName = 'Kovalsky';
        $this->salary = 5000;
    }

    public function testCannotCreateWorkerWhenDepartmentNotFound(): void
    {
        // Given
        $factory = new WorkerFactory(new NotFoundDepartments(), $this->clock);

        // Expect
        $this->expectException(DepartmentNotFound::class);

        // When
        $factory->fromScalars(
            $this->workerId,
            $this->departmentId,
            $this->firstName,
            $this->lastName,
            $this->salary
        );
    }

    public function testWorkerCreatedSuccessfully(): void
    {
        // Given
        $factory = new WorkerFactory(
            StubDepartments::whenAlways(DepartmentMother::random()),
            $this->clock
        );

        // When
        $worker = $factory->fromScalars(
            $this->workerId,
            $this->departmentId,
            $this->firstName,
            $this->lastName,
            $this->salary
        );

        // Then
        self::assertEquals($this->workerId, $worker->id(), 'IDs of workers should be the same');
    }
}
