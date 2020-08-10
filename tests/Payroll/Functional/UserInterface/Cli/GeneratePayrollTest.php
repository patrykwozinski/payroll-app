<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Functional\UserInterface\Cli;

use App\Payroll\Domain\Department;
use App\Payroll\Domain\Departments;
use App\Payroll\Domain\Workers;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use App\Tests\Payroll\ObjectMother\Domain\WorkerMother;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class GeneratePayrollTest extends KernelTestCase
{
    private Command $command;
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $kernel = static::bootKernel();
        $application = new Application($kernel);

        $this->command = $application->find('payroll:generate');
        $this->commandTester = new CommandTester($this->command);
    }

    public function testCannotGenerateWhenInvalidDate(): void
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'date' => 'halko',
        ]);
        $output = $this->commandTester->getDisplay();

        self::assertStringContainsString('Invalid date format', $output);
    }

    public function testPayrollGenerated(): void
    {
        $this->ensureWorkerExists();

        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'date' => '2020-02-02',
        ]);
        $output = $this->commandTester->getDisplay();

        self::assertStringContainsString('Payroll generated successfully', $output);
    }

    private function ensureWorkerExists(): void
    {
        /** @var Departments $departments */
        $departments = self::$container->get(Departments::class);
        $departments->add(DepartmentMother::random());

        /** @var Workers $workers */
        $workers = self::$container->get(Workers::class);
        $workers->add(WorkerMother::make()->build());
    }
}
