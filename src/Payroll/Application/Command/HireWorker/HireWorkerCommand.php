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

    public function __construct(string $id, string $firstName, string $lastName, string $department, int $salary)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->department = $department;
        $this->salary = $salary;
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
}
