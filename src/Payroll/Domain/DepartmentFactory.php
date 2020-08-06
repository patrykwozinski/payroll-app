<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Payroll\Domain\Error\DepartmentNameIsTaken;

final class DepartmentFactory
{
    private Departments $departments;

    public function __construct(Departments $departments)
    {
        $this->departments = $departments;
    }

    public function create(DepartmentId $departmentId, string $name, string $bonusType, int $bonusValue): Department
    {
        if ($this->departments->existsWithSameName($name)) {
            throw DepartmentNameIsTaken::withName($name);
        }

        return new Department(
            $departmentId,
            $name,
            BonusType::fromScalars($bonusType, $bonusValue)
        );
    }
}
