<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain;

use App\Common\Date;
use App\Payroll\Domain\Error\CannotGenerateEmptyPayroll;
use App\Payroll\Domain\PayrollGenerator;
use App\Payroll\Domain\PayrollId;
use App\Payroll\Infrastructure\InMemory\InMemoryWorkers;
use App\Tests\Payroll\ObjectMother\Domain\WorkerMother;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class PayrollGeneratorTest extends TestCase
{
    private InMemoryWorkers $inMemoryWorkers;
    private PayrollGenerator $payrollGenerator;
    private Date $date;

    protected function setUp(): void
    {
        $this->inMemoryWorkers = new InMemoryWorkers();
        $this->payrollGenerator = new PayrollGenerator($this->inMemoryWorkers, []);
        $this->date = new Date(new DateTimeImmutable('2020-01-05'));
    }

    public function testCannotGeneratedPayrollWhenNoWorkers(): void
    {
        // Given
        $payrollId = PayrollId::random();

        // Expect
        $this->expectException(CannotGenerateEmptyPayroll::class);

        // When
        $this->payrollGenerator->generate($payrollId, $this->date);
    }

    public function testGeneratedPayrollIsNotEmptyWhenWorkersFound(): void
    {
        // Given
        $payrollId = PayrollId::random();
        $this->inMemoryWorkers->add(WorkerMother::make()->build());

        // When
        $payroll = $this->payrollGenerator->generate($payrollId, $this->date);

        // Then
        self::assertFalse($payroll->isEmpty(), 'Payroll should not be empty when workers found');
    }
}
