<?php

declare(strict_types=1);

namespace App\Tests\Payroll\ObjectMother\Domain;

use App\Payroll\Domain\Seniority;

final class SeniorityMother
{
    public static function random(): Seniority
    {
        return new Seniority(2);
    }
}
