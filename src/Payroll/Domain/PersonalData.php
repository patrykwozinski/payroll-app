<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use Webmozart\Assert\Assert;

final class PersonalData
{
    private string $firstName;
    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        Assert::notEmpty($firstName, 'First name can not be empty');
        Assert::notEmpty($lastName, 'Last name can not be empty');

        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}
