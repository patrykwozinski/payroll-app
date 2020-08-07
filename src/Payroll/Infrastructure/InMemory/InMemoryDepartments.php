<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\InMemory;

use App\Payroll\Domain\Department;
use App\Payroll\Domain\DepartmentId;
use App\Payroll\Domain\Departments;
use App\Payroll\Domain\Error\DepartmentNotFound;

final class InMemoryDepartments implements Departments
{
    /** @var Department[] */
    private array $departments = [];

    public function ofId(DepartmentId $departmentId): Department
    {
        $department = $this->departments[(string) $departmentId] ?? null;

        if (null === $department) {
            throw DepartmentNotFound::withId($departmentId);
        }

        return $department;
    }

    public function add(Department $department): void
    {
        $this->departments[(string) $department->id()] = $department;
    }

    public function existsWithSameName(string $name): bool
    {
        foreach ($this->departments as $department) {
            if ($department->name() === $name) {
                return true;
            }
        }

        return false;
    }
}
