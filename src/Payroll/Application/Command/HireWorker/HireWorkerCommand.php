<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\HireWorker;

use App\Common\Application\Command;

final class HireWorkerCommand implements Command
{
    private string $id;
    private string $firstName;
    private string $lastName;
    private string $department;
    private int $salary;
    private string $bonusType;
    private int $bonusValue;

    public function __construct(string $id, string $firstName, string $lastName, string $department, int $salary, string $bonusType, int $bonusValue)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->department = $department;
        $this->salary = $salary;
        $this->bonusType = $bonusType;
        $this->bonusValue = $bonusValue;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function departmentId(): string
    {
        return $this->department;
    }

    public function salary(): int
    {
        return $this->salary;
    }

    public function bonusType(): string
    {
        return $this->bonusType;
    }

    public function bonusValue(): int
    {
        return $this->bonusValue;
    }
}
