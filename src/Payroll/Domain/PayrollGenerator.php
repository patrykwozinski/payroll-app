<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Date;
use App\Common\Domain\Clock;
use App\Payroll\Domain\Error\CannotGenerateEmptyPayroll;

final class PayrollGenerator
{
    private Workers $workers;
    private Clock $clock;
    /** @var BonusCalculator[] */
    private array $bonusCalculators;

    public function __construct(Workers $workers, Clock $clock, array $bonusCalculators)
    {
        $this->workers = $workers;
        $this->clock = $clock;
        $this->bonusCalculators = $bonusCalculators;
    }

    /** @throws CannotGenerateEmptyPayroll */
    public function generate(PayrollId $payrollId, Date $date): Payroll
    {
        $payroll = Payroll::generate($payrollId, $this->clock->now());

        foreach ($this->workers->workingUntil($date) as $worker) {
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
