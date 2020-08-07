<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\ORM\Domain;

use App\Payroll\Domain\Payroll;
use App\Payroll\Domain\Payrolls;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineORMPayrolls implements Payrolls
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Payroll $payroll): void
    {
        $this->entityManager->persist($payroll);
        $this->entityManager->flush();
    }
}
