<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Domain\Clock;

final class WorkerFactory
{
    private Departments $departments;
    private Clock $clock;

    public function __construct(Departments $departments, Clock $clock)
    {
        $this->departments = $departments;
        $this->clock = $clock;
    }

    public function create(WorkerId $workerId, DepartmentId $departmentId, string $firstName, string $lastName, int $salary): Worker
    {
        $department = $this->departments->oneById($departmentId);

        return Worker::hire(
            $workerId,
            new PersonalData($firstName, $lastName),
            $department,
            new Money($salary),
            $this->clock->now()
        );
    }
}
