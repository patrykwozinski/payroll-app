<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

interface PayrollQuery
{
    public function ofId(string $payrollId): Payroll;
}
