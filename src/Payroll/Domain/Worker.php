<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Domain\AggregateRoot;
use App\Payroll\Domain\Event\WorkerHired;

final class Worker extends AggregateRoot
{
    private WorkerId $id;
    private string $firstName;
    private string $lastName;

    public function __construct(WorkerId $id, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function hire(WorkerId $id, string $firstName, string $lastName): self
    {
        $worker = new self($id, $firstName, $lastName);
        $worker->recordThat(new WorkerHired($id));

        return $worker;
    }
}
