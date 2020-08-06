<?php

declare(strict_types=1);

namespace App\Tests\Payroll\ObjectMother\Domain;

use App\Payroll\Domain\BonusType;
use App\Payroll\Domain\Department;
use App\Payroll\Domain\DepartmentId;

final class DepartmentMother
{
    public const ID = '476cc55f-02ba-4f9f-9e12-86ebfc1094a5';

    public static function random(): Department
    {
        return new Department(DepartmentId::fromString(self::ID), 'HR', BonusType::yearly(10));
    }
}
