<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\HireWorker;

use App\Common\Application\Command\Handler;
use App\Payroll\Domain\DepartmentId;
use App\Payroll\Domain\WorkerFactory;
use App\Payroll\Domain\WorkerId;
use App\Payroll\Domain\Workers;

final class HireWorkerHandler implements Handler
{
    private WorkerFactory $workerFactory;
    private Workers $workers;

    public function __construct(WorkerFactory $workerFactory, Workers $workers)
    {
        $this->workerFactory = $workerFactory;
        $this->workers = $workers;
    }

    public function __invoke(HireWorkerCommand $command): void
    {
        $worker = $this->workerFactory->create(
            WorkerId::fromString($command->id()),
            DepartmentId::fromString($command->departmentId()),
            $command->firstName(),
            $command->lastName(),
            $command->salary()
        );

        $this->workers->add($worker);
    }
}
