<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class Seniority
{
    private int $years;

    public function __construct(int $years)
    {
        $this->years = $years;
    }
}
