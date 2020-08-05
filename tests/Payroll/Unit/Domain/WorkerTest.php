<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain;

use App\Payroll\Domain\Event\WorkerHired;
use App\Payroll\Domain\Worker;
use App\Payroll\Domain\WorkerId;
use PHPUnit\Framework\TestCase;

final class WorkerTest extends TestCase
{
    public function testWorkerSuccessfullyHired(): void
    {
        // Arrange
        $id = WorkerId::random();
        $firstName = 'Kevin';
        $lastName = 'Mitnick';

        // Act
        $worker = Worker::hire($id, $firstName, $lastName);

        // Assert
        $recordedEvent = $worker->pullEvents()[0];
        $expectedEvent = new WorkerHired($id);
        self::assertEquals($expectedEvent, $recordedEvent, 'Worker should be hired');
    }
}
