<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain;

use App\Payroll\Domain\DepartmentFactory;
use App\Payroll\Domain\DepartmentId;
use App\Payroll\Domain\Error\DepartmentNameIsTaken;
use App\Payroll\Infrastructure\InMemory\InMemoryDepartments;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use PHPUnit\Framework\TestCase;

final class DepartmentFactoryTest extends TestCase
{
    private InMemoryDepartments $inMemoryDepartments;
    private DepartmentFactory $departmentFactory;

    protected function setUp(): void
    {
        $this->inMemoryDepartments = new InMemoryDepartments();
        $this->departmentFactory = new DepartmentFactory($this->inMemoryDepartments);
    }

    public function testCannotCreateDepartmentWhenNameIsNotUnique(): void
    {
        // Given
        $departmentId = DepartmentId::fromString(DepartmentMother::ID);
        $name = DepartmentMother::NAME;
        $bonusType = 'yearly';
        $bonusValue = 5000;

        // When exists with the same name
        $this->inMemoryDepartments->add(DepartmentMother::random());

        // Expect
        $this->expectException(DepartmentNameIsTaken::class);

        // When
        $this->departmentFactory->create($departmentId, $name, $bonusType, $bonusValue);
    }

    public function testDepartmentSuccessfullyCreatedWithTheSameId(): void
    {
        // Given
        $departmentId = DepartmentId::fromString(DepartmentMother::ID);
        $name = DepartmentMother::NAME;
        $bonusType = 'yearly';
        $bonusValue = 5000;

        // When
        $department = $this->departmentFactory->create($departmentId, $name, $bonusType, $bonusValue);

        // Then
        self::assertEquals($departmentId, $department->id());
    }
}
