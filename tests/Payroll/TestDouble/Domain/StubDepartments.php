<?php

declare(strict_types=1);

namespace App\Tests\Payroll\TestDouble\Domain;

use App\Payroll\Domain\Department;
use App\Payroll\Domain\DepartmentId;
use App\Payroll\Domain\Departments;

final class StubDepartments implements Departments
{
    private Department $department;

    private function __construct(Department $department)
    {
        $this->department = $department;
    }

    public static function whenAlways(Department $department): self
    {
        return new self($department);
    }

    public function oneById(DepartmentId $departmentId): Department
    {
        return $this->department;
    }
}
