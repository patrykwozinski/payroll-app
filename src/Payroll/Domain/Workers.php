<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

interface Workers
{
    public function add(Worker $worker): void;
}
