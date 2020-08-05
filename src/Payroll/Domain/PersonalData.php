<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class PersonalData
{
    private string $firstName;
    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}
