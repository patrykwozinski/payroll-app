<?php

declare(strict_types=1);

namespace App\Tests\Payroll\ObjectMother\Domain;

use App\Payroll\Domain\Department;

final class DepartmentMother
{
    public static function random(): Department
    {
        return new Department('HR');
    }
}
