<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Event;

use App\Common\Domain\Event;
use App\Payroll\Domain\WorkerId;

final class WorkerHired implements Event
{
    private WorkerId $workerId;

    public function __construct(WorkerId $workerId)
    {
        $this->workerId = $workerId;
    }
}
