<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Event;

use App\Common\Domain\Event;
use App\Payroll\Domain\BonusSalary;
use App\Payroll\Domain\WorkerId;

final class BonusSalaryRecalculated implements Event
{
    private WorkerId $workerId;
    private BonusSalary $previousBonus;
    private BonusSalary $actualBonus;

    public function __construct(WorkerId $workerId, BonusSalary $previousBonus, BonusSalary $actualBonus)
    {
        $this->workerId = $workerId;
        $this->previousBonus = $previousBonus;
        $this->actualBonus = $actualBonus;
    }
}
