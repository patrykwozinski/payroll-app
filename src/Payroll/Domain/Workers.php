<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Calendar\Date;

interface Workers
{
    public function add(Worker $worker): void;

    /** @return Worker[] */
    public function workingUntil(Date $date): array;
}
