<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class PayrollRecord
{
    private PayrollRecordId $id;
    private WorkerSnapshot $workerSnapshot;
    private Money $salaryBonus;

    public function __construct(PayrollRecordId $id, WorkerSnapshot $workerSnapshot, Money $salaryBonus)
    {
        $this->id = $id;
        $this->workerSnapshot = $workerSnapshot;
        $this->salaryBonus = $salaryBonus;
    }
}
