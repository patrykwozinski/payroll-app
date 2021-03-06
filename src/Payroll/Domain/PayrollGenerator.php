<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Calendar\Clock;
use App\Common\Calendar\Date;
use App\Payroll\Domain\BonusCalculator\PercentageBonusCalculator;
use App\Payroll\Domain\BonusCalculator\YearlyBonusCalculator;
use App\Payroll\Domain\Error\CannotGenerateEmptyPayroll;

final class PayrollGenerator
{
    private Workers $workers;
    private Clock $clock;
    private YearlyBonusCalculator $yearlyBonusCalculator;
    private PercentageBonusCalculator $percentageBonusCalculator;

    public function __construct(Workers $workers, Clock $clock, YearlyBonusCalculator $yearlyBonusCalculator, PercentageBonusCalculator $percentageBonusCalculator)
    {
        $this->workers = $workers;
        $this->clock = $clock;
        $this->yearlyBonusCalculator = $yearlyBonusCalculator;
        $this->percentageBonusCalculator = $percentageBonusCalculator;
    }

    /** @throws CannotGenerateEmptyPayroll */
    public function generate(PayrollId $payrollId, Date $date): Payroll
    {
        $payroll = Payroll::generate($payrollId, $this->clock->now());

        foreach ($this->workers->workingInDate($date) as $worker) {
            $salaryBonus = $worker->salaryBonus(
                $this->yearlyBonusCalculator,
                $this->percentageBonusCalculator
            );

            $payroll->add(
                new PayrollRecord(
                    PayrollRecordId::random(),
                    $payroll,
                    $worker->id(),
                    $worker->personalData(),
                    $worker->department(),
                    $worker->salary(),
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
