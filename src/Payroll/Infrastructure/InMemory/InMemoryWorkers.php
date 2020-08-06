<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\InMemory;

use App\Payroll\Domain\Worker;
use App\Payroll\Domain\Workers;

final class InMemoryWorkers implements Workers
{
    /** @var Worker[] */
    private array $workers = []; // meh we need typed arrays ;(

    public function add(Worker $worker): void
    {
        $this->workers[] = $worker;
    }
}
