<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\InMemory;

use App\Payroll\Domain\Payroll;
use App\Payroll\Domain\Payrolls;

final class InMemoryPayrolls implements Payrolls
{
    /** @var Payroll[] */
    private array $payrolls = [];

    public function add(Payroll $payroll): void
    {
        $this->payrolls[] = $payroll;
    }
}
