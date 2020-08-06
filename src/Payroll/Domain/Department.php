<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class Department
{
    private DepartmentId $id;
    private string $name;
    private BonusType $bonusType;

    public function __construct(DepartmentId $id, string $name, BonusType $bonusType)
    {
        $this->id = $id;
        $this->name = $name;
        $this->bonusType = $bonusType;
    }

    public function id(): DepartmentId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function bonusType(): BonusType
    {
        return $this->bonusType;
    }
}
