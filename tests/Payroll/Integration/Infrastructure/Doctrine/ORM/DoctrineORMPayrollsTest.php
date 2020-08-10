<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Integration\Infrastructure\Doctrine\ORM;

use App\Common\Calendar\Date;
use App\Payroll\Domain\Payroll;
use App\Payroll\Domain\PayrollId;
use App\Payroll\Infrastructure\Doctrine\ORM\Domain\DoctrineORMPayrolls;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DoctrineORMPayrollsTest extends KernelTestCase
{
    private DoctrineORMPayrolls $repository;
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        static::bootKernel();

        /** @var EntityManagerInterface $em */
        $em = self::$container->get(EntityManagerInterface::class);
        $this->em = $em;
        $this->repository = new DoctrineORMPayrolls($this->em);
    }

    public function testPayrollSuccessfullyAdded(): void
    {
        $generatedAt = new Date(new DateTimeImmutable('2020-02-02'));
        $payroll = Payroll::generate(PayrollId::random(), $generatedAt);

        $this->repository->add($payroll);

        /** @var Payroll $existing */
        $existing = $this->em->getRepository(Payroll::class)->find((string)$payroll->id());

        self::assertEquals($payroll->id(), $existing->id());
    }
}
