<?php

declare(strict_types=1);

namespace App\Tests\Payroll\ObjectMother\Domain;

use App\Payroll\Domain\BonusType;
use App\Payroll\Domain\Department;
use App\Payroll\Domain\DepartmentId;

final class DepartmentMother
{
    public const ID = '476cc55f-02ba-4f9f-9e12-86ebfc1094a5';
    public const NAME = 'IT and operations';

    public static function random(): Department
    {
        return new Department(DepartmentId::fromString(self::ID), self::NAME, BonusType::yearly(10));
    }

    public static function withPercentageBonus(int $amount): Department
    {
        return new Department(DepartmentId::fromString(self::ID), self::NAME, BonusType::percentage($amount));
    }

    public static function withYearlyBonus(int $amount): Department
    {
        return new Department(DepartmentId::fromString(self::ID), self::NAME, BonusType::yearly($amount));
    }
}
