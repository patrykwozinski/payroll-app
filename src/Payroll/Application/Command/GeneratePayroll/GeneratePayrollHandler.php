<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\GeneratePayroll;

use App\Common\CQRS\CommandHandler;
use App\Payroll\Domain\PayrollGenerator;
use App\Payroll\Domain\PayrollId;
use App\Payroll\Domain\Payrolls;

final class GeneratePayrollHandler implements CommandHandler
{
    private PayrollGenerator $payrollGenerator;
    private Payrolls $payrolls;

    public function __construct(PayrollGenerator $payrollGenerator, Payrolls $payrolls)
    {
        $this->payrollGenerator = $payrollGenerator;
        $this->payrolls = $payrolls;
    }

    public function __invoke(GeneratePayrollCommand $command): void
    {
        $payrollId = PayrollId::fromString($command->payrollId());
        $payroll = $this->payrollGenerator->generate($payrollId, $command->date());

        $this->payrolls->add($payroll);
    }
}
