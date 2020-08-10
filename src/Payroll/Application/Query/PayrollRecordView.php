<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

final class PayrollRecordView
{
    private string $firstName;
    private string $lastName;
    private string $department;
    private int $salary;
    private int $salaryBonus;
    private string $bonusType;

    public function __construct(string $firstName, string $lastName, string $department, int $salary, int $salaryBonus, string $bonusType)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->department = $department;
        $this->salary = $salary;
        $this->salaryBonus = $salaryBonus;
        $this->bonusType = $bonusType;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function department(): string
    {
        return $this->department;
    }

    public function salary(): int
    {
        return $this->salary;
    }

    public function salaryBonus(): int
    {
        return $this->salaryBonus;
    }

    public function bonusType(): string
    {
        return $this->bonusType;
    }
}
