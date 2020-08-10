<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\DBAL\Application;

use App\Common\Calendar\Date;
use App\Payroll\Application\Query\PayrollFilter;
use App\Payroll\Application\Query\PayrollQuery;
use App\Payroll\Application\Query\PayrollRecordView;
use App\Payroll\Application\Query\PayrollView;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\ResultStatement;
use Doctrine\DBAL\Query\QueryBuilder;
use Ramsey\Uuid\UuidInterface;

final class DoctrineDBALPayrollQuery implements PayrollQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(UuidInterface $payrollId, PayrollFilter $filter): ?PayrollView
    {
        /** @var QueryBuilder $query */
        $query = $this->connection
            ->createQueryBuilder()
            ->select([
                'p.id',
                'p.generated_at',
                'pr.first_name as worker_first_name',
                'pr.last_name as worker_last_name',
                'pr.salary as salary',
                'pr.salary_bonus as salary_bonus',
                'd.name as department_name',
                'd.bonus_type as department_bonus_type',
                'pr.salary + pr.salary_bonus as total_salary',
            ])
            ->from('payroll', 'p')
            ->innerJoin('p', 'payroll_record', 'pr', 'p.id = pr.payroll_id')
            ->innerJoin('pr', 'department', 'd', 'pr.department_id = d.id')
            ->where('p.id = :payrollId');

        if ($filter->hasSorter()) {
            $query->orderBy($filter->sorter()->field(), $filter->sorter()->direction());
        }

        /** @var ResultStatement $statement */
        $query = $query
            ->setParameter('payrollId', (string)$payrollId)
            ->execute();

        $rawPayroll = $query->fetchAll();

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
                $rawRecord['department_bonus_type'],
                (int)$rawRecord['total_salary'],
            );
        }

        return new PayrollView(
            $rawPayroll[0]['id'],
            new Date(new DateTimeImmutable($rawPayroll[0]['generated_at'])),
            $rows
        );
    }
}
