<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Integration\Infrastructure\Doctrine\ORM;

use App\Common\Calendar\Date;
use App\Payroll\Domain\Worker;
use App\Payroll\Infrastructure\Doctrine\ORM\Domain\DoctrineORMWorkers;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use App\Tests\Payroll\ObjectMother\Domain\WorkerMother;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DoctrineORMWorkersTest extends KernelTestCase
{
    private DoctrineORMWorkers $repository;
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        static::bootKernel();

        /** @var EntityManagerInterface $em */
        $em = self::$container->get(EntityManagerInterface::class);
        $this->em = $em;
        $this->repository = new DoctrineORMWorkers($this->em);
    }

    public function testNewWorkerSuccessfullyAdded(): void
    {
        $department = DepartmentMother::random();

        $this->em->persist($department);
        $this->em->flush();

        $worker = WorkerMother::make()
            ->withDepartment($department)
            ->build();

        $this->repository->add($worker);

        /** @var Worker $existing */
        $existing = $this->em->getRepository(Worker::class)->find((string)$worker->id());

        self::assertEquals($worker->id(), $existing->id());
    }

    public function testFoundOnlyWorkersHiredBeforeDate(): void
    {
        $now = new DateTimeImmutable('2020-02-02');

        $department = DepartmentMother::random();

        $worker1 = WorkerMother::make()
            ->withDepartment($department)
            ->withHiredAt(new Date($now->modify('-1 day')))
            ->build();

        $worker2 = WorkerMother::make()
            ->withDepartment($department)
            ->withHiredAt(new Date($now->modify('+1 day')))
            ->build();

        $this->em->persist($department);
        $this->em->persist($worker1);
        $this->em->persist($worker2);
        $this->em->flush();

        self::assertCount(1, $this->repository->workingInDate(new Date($now)));
    }
}
