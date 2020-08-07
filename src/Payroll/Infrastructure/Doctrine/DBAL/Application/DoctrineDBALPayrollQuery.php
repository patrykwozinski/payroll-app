<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\DBAL\Application;

use App\Payroll\Application\Query\Payroll;
use App\Payroll\Application\Query\PayrollQuery;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class DoctrineDBALPayrollQuery implements PayrollQuery
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function ofId(UuidInterface $payrollId): Payroll
    {
        return new Payroll();
    }
}
