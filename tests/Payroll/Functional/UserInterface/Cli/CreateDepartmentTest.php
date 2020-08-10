<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Functional\UserInterface\Cli;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class CreateDepartmentTest extends KernelTestCase
{
    private Command $command;
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $kernel = static::bootKernel();
        $application = new Application($kernel);

        $this->command = $application->find('payroll:create-department');
        $this->commandTester = new CommandTester($this->command);
    }

    public function testDepartmentCreated(): void
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'name' => 'IT operations',
            'bonus-type' => 'Yearly',
            'bonus-value' => 700,
        ]);
        $output = $this->commandTester->getDisplay();

        self::assertStringContainsString('Created department!', $output);
    }
}
