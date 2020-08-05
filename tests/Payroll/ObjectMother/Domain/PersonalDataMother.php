<?php

declare(strict_types=1);

namespace App\Tests\Payroll\ObjectMother\Domain;

use App\Payroll\Domain\PersonalData;

final class PersonalDataMother
{
    public static function random(): PersonalData
    {
        return new PersonalData('Kevin', 'Mitnick');
    }
}
