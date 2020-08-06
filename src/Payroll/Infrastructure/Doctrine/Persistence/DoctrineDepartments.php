<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\Persistence;

use App\Payroll\Domain\Department;
use App\Payroll\Domain\DepartmentId;
use App\Payroll\Domain\Departments;
use App\Payroll\Domain\Error\DepartmentNotFound;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineDepartments implements Departments
{
    /** @var EntityManagerInterface */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function oneById(DepartmentId $departmentId): Department
    {
        /** @var Department|null $department */
        $department = $this->entityManager->find(Department::class, $departmentId);

        if (null === $department) {
            throw DepartmentNotFound::withId($departmentId);
        }

        return $department;
    }
}
