<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain;

use App\Common\Calendar\Clock\FixedClock;
use App\Common\Calendar\Date;
use App\Payroll\Domain\DepartmentId;
use App\Payroll\Domain\Error\DepartmentNotFound;
use App\Payroll\Domain\WorkerFactory;
use App\Payroll\Domain\WorkerId;
use App\Payroll\Infrastructure\InMemory\InMemoryDepartments;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class WorkerFactoryTest extends TestCase
{
    private InMemoryDepartments $inMemoryDepartments;
    private FixedClock $clock;
    private WorkerId $workerId;
    private DepartmentId $departmentId;
    private string $firstName;
    private string $lastName;
    private int $salary;

    protected function setUp(): void
    {
        $this->inMemoryDepartments = new InMemoryDepartments();

        // Background
        $fixedDate = new Date(new DateTimeImmutable('2019-02-02 21:37:00'));
        $this->clock = FixedClock::on($fixedDate);
        $this->workerId = WorkerId::random();
        $this->departmentId = DepartmentId::fromString(DepartmentMother::ID);
        $this->firstName = 'John';
        $this->lastName = 'Kovalsky';
        $this->salary = 5000;
    }

    public function testCannotCreateWorkerWhenDepartmentNotFound(): void
    {
        // Given
        $factory = new WorkerFactory($this->inMemoryDepartments, $this->clock);

        // Expect
        $this->expectException(DepartmentNotFound::class);

        // When
        $factory->create(
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
        $this->inMemoryDepartments->add(DepartmentMother::random());
        $factory = new WorkerFactory(
            $this->inMemoryDepartments,
            $this->clock
        );

        // When
        $worker = $factory->create(
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
