<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\ReadModel;

use App\Payroll\Application\Query\Payroll;
use App\Payroll\Application\Query\PayrollQuery;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrinePayrollQuery implements PayrollQuery
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function ofId(string $payrollId): Payroll
    {
        return new Payroll();
    }
}
