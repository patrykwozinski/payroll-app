<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\GeneratePayroll;

use App\Common\Application\Command;
use App\Common\Date;

final class GeneratePayrollCommand implements Command
{
    private string $payrollId;
    private Date $date;

    public function __construct(string $payrollId, Date $date)
    {
        $this->payrollId = $payrollId;
        $this->date = $date;
    }

    public function payrollId(): string
    {
        return $this->payrollId;
    }

    public function date(): Date
    {
        return $this->date;
    }
}
