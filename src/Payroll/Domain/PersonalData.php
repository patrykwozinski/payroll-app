<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use Assert\Assertion;

final class PersonalData
{
    private string $firstName;
    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        Assertion::notEmpty($firstName, 'First name can not be empty');
        Assertion::notEmpty($lastName, 'Last name can not be empty');

        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}
