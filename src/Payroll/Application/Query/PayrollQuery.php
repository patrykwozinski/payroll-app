<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

use App\Common\CQRS\Query;
use Ramsey\Uuid\UuidInterface;

interface PayrollQuery extends Query
{
    public function find(UuidInterface $payrollId, PayrollFilter $filter): ?PayrollView;
}
