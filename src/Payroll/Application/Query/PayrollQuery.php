<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

use Ramsey\Uuid\UuidInterface;

interface PayrollQuery
{
    public function ofId(UuidInterface $payrollId): Payroll;
}
