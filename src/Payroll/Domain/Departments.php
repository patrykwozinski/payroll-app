<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Payroll\Domain\Error\DepartmentNotFound;

interface Departments
{
    /** @throws DepartmentNotFound */
    public function oneById(DepartmentId $departmentId): Department;
}
