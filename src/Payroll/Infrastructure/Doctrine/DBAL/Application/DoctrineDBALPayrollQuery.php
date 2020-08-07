<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\DBAL\Application;

use App\Common\Calendar\Date;
use App\Payroll\Application\Query\PayrollQuery;
use App\Payroll\Application\Query\PayrollView;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\UuidInterface;

final class DoctrineDBALPayrollQuery implements PayrollQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function ofId(UuidInterface $payrollId): ?PayrollView
    {
        $rawPayroll = $this->connection
            ->createQueryBuilder()
            ->select([
                'p.id',
                'p.generated_at',
            ])
            ->from('payroll', 'p')
            ->where('p.id = :payrollId')
            ->setParameter('payrollId', (string)$payrollId)
            ->execute()
            ->fetch();

        if (null === $rawPayroll) {
            return null;
        }

        return $this->assemblePayroll($rawPayroll);
    }

    private function assemblePayroll(array $rawPayroll): PayrollView
    {
        return new PayrollView(
            $rawPayroll['id'],
            new Date(new DateTimeImmutable($rawPayroll['generated_at']))
        );
    }
}
