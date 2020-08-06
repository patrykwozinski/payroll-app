<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\CreateDepartment;

use App\Common\Application\Command;

final class CreateDepartmentCommand implements Command
{
    private string $id;
    private string $name;
    private string $bonusType;
    private int $bonusValue;

    public function __construct(string $id, string $name, string $bonusType, int $bonusValue)
    {
        $this->id = $id;
        $this->name = $name;
        $this->bonusType = $bonusType;
        $this->bonusValue = $bonusValue;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
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
