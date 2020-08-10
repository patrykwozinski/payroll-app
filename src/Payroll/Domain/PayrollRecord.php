<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class PayrollRecord
{
    private PayrollRecordId $id;
    private Payroll $payroll;
    private WorkerId $workerId;
    private PersonalData $personalData;
    private Department $department;
    private Money $salary;
    private Money $salaryBonus;

    public function __construct(PayrollRecordId $id, Payroll $payroll, WorkerId $workerId, PersonalData $personalData, Department $department, Money $salary, Money $salaryBonus)
    {
        $this->id = $id;
        $this->payroll = $payroll;
        $this->workerId = $workerId;
        $this->personalData = $personalData;
        $this->department = $department;
        $this->salary = $salary;
        $this->salaryBonus = $salaryBonus;
    }
}
