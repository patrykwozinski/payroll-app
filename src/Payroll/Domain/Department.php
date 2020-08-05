<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class Department
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
