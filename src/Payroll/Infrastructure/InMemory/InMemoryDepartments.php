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
    private array $departments;

    public function oneById(DepartmentId $departmentId): Department
    {
        $department = $this->departments[(string) $departmentId] ?? null;

        if (null === $department) {
            throw DepartmentNotFound::withId($departmentId);
        }

        return $department;
    }
}
