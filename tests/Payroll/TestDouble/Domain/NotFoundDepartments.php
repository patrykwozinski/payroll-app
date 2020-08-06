<?php

declare(strict_types=1);

namespace App\Tests\Payroll\TestDouble\Domain;

use App\Payroll\Domain\Department;
use App\Payroll\Domain\DepartmentId;
use App\Payroll\Domain\Departments;
use App\Payroll\Domain\Error\DepartmentNotFound;

final class NotFoundDepartments implements Departments
{
    public function oneById(DepartmentId $departmentId): Department
    {
        throw DepartmentNotFound::withId($departmentId);
    }
}
