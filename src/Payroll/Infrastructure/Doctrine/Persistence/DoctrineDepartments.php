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

    public function add(Department $department): void
    {
        $this->entityManager->persist($department);
        $this->entityManager->flush();
    }

    public function existsWithSameName(string $name): bool
    {
        $result = $this->entityManager
            ->createQueryBuilder()
            ->select('1')
            ->from('department', 'd')
            ->where('d.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();

        dump($result);

        return true;
    }
}
