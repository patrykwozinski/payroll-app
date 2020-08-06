<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\CreateDepartment;

use App\Common\Application\Command\Handler;
use App\Payroll\Domain\DepartmentFactory;
use App\Payroll\Domain\DepartmentId;
use App\Payroll\Domain\Departments;

final class CreateDepartmentHandler implements Handler
{
    private DepartmentFactory $departmentFactory;
    private Departments $departments;

    public function __construct(DepartmentFactory $departmentFactory, Departments $departments)
    {
        $this->departmentFactory = $departmentFactory;
        $this->departments = $departments;
    }

    public function __invoke(CreateDepartmentCommand $command): void
    {
        $department = $this->departmentFactory->create(
            DepartmentId::fromString($command->id()),
            $command->name(),
            $command->bonusType(),
            $command->bonusValue()
        );

        $this->departments->add($department);
    }
}
