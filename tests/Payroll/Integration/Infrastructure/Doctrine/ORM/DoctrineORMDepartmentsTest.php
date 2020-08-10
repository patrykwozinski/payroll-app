<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Integration\Infrastructure\Doctrine\ORM;

use App\Payroll\Domain\Department;
use App\Payroll\Domain\DepartmentId;
use App\Payroll\Domain\Error\DepartmentNotFound;
use App\Payroll\Infrastructure\Doctrine\ORM\Domain\DoctrineORMDepartments;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DoctrineORMDepartmentsTest extends KernelTestCase
{
    private DoctrineORMDepartments $repository;
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        static::bootKernel();

        /** @var EntityManagerInterface $em */
        $em = self::$container->get(EntityManagerInterface::class);
        $this->em = $em;
        $this->repository = new DoctrineORMDepartments($this->em);
    }

    public function testDepartmentSuccessfullyAdded(): void
    {
        $department = DepartmentMother::random();

        $this->repository->add($department);

        /** @var Department $existing */
        $existing = $this->repository->ofId($department->id());

        self::assertEquals($department->id(), $existing->id(), 'Added repository can be found by ID');
    }

    public function testDepartmentNotFoundWhenDoesntExist(): void
    {
        $this->expectException(DepartmentNotFound::class);

        $this->repository->ofId(DepartmentId::fromString('1df9cfb6-4108-4c04-a9a7-a4cbb0802cbf'));
    }

    public function testDepartmentWithTheSameNameExistsWhenPersisted(): void
    {
        $department = DepartmentMother::random();

        self::assertFalse($this->repository->existsWithSameName($department->name()), 'Should be not found when not saved');

        $this->em->persist($department);
        $this->em->flush();

        self::assertTrue($this->repository->existsWithSameName($department->name()), 'Should be found when saved');
    }
}
