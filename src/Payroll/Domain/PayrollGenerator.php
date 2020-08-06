<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Date;
use App\Payroll\Domain\Error\CannotGenerateEmptyPayroll;

final class PayrollGenerator
{
    private Workers $workers;
    /** @var BonusCalculator[] */
    private array $bonusCalculators;

    public function __construct(Workers $workers, array $bonusCalculators)
    {
        $this->workers = $workers;
        $this->bonusCalculators = $bonusCalculators;
    }

    /** @throws CannotGenerateEmptyPayroll */
    public function generate(PayrollId $payrollId, Date $date): Payroll
    {
        $payroll = Payroll::generate($payrollId, $date);

        foreach ($this->workers->all() as $worker) {
            $salaryBonus = $worker->salaryBonus(...$this->bonusCalculators);

            $payroll->add(
                new PayrollRecord(
                    PayrollRecordId::random(),
                    $worker->snapshot(),
                    $salaryBonus
                )
            );
        }

        if ($payroll->isEmpty()) {
            throw CannotGenerateEmptyPayroll::forDate($date);
        }

        return $payroll;
    }
}
