<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\DBAL\Application;

use App\Common\Calendar\Date;
use App\Payroll\Application\Query\PayrollQuery;
use App\Payroll\Application\Query\PayrollRecordView;
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
                'pr.first_name as worker_first_name',
                'pr.last_name as worker_last_name',
                'pr.salary',
                'pr.salary_bonus',
                'd.name as department_name',
                'd.bonus_type as department_bonus_type',
            ])
            ->from('payroll', 'p')
            ->innerJoin('p', 'payroll_record', 'pr', 'p.id = pr.payroll_id')
            ->innerJoin('pr', 'department', 'd', 'pr.department_id = d.id')
            ->where('p.id = :payrollId')
            ->setParameter('payrollId', (string)$payrollId)
            ->execute()
            ->fetchAll();

        if (empty($rawPayroll)) {
            return null;
        }

        return $this->assemblePayroll($rawPayroll);
    }

    private function assemblePayroll(array $rawPayroll): PayrollView
    {
        $rows = [];

        foreach ($rawPayroll as $rawRecord) {
            $rows[] = new PayrollRecordView(
                $rawRecord['worker_first_name'],
                $rawRecord['worker_last_name'],
                $rawRecord['department_name'],
                (int)$rawRecord['salary'],
                (int)$rawRecord['salary_bonus'],
                $rawRecord['department_bonus_type']
            );
        }

        return new PayrollView(
            $rawPayroll[0]['id'],
            new Date(new DateTimeImmutable($rawPayroll[0]['generated_at'])),
            $rows
        );
    }
}
