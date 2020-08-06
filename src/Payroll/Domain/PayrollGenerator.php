<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Date;

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

    public function generate(PayrollId $payrollId, Date $date): Payroll
    {
        $workers = $this->workers->all();
        $payroll = Payroll::generate($payrollId, $date);

        foreach ($workers as $worker) {
            $salaryBonus = $worker->salaryBonus(...$this->bonusCalculators);

            $payroll->add(
                new PayrollRecord(
                    PayrollRecordId::random(),
                    $worker->snapshot(),
                    $salaryBonus
                )
            );
        }

        return $payroll;
    }
}
