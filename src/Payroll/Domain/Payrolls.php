<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

interface Payrolls
{
    public function add(Payroll $payroll): void;
}
