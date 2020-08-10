<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Functional\UserInterface\Cli;

use App\Payroll\Domain\Departments;
use App\Tests\Payroll\ObjectMother\Domain\DepartmentMother;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class HireWorkerTest extends KernelTestCase
{
    private Command $createDepartment;
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $kernel = static::bootKernel();
        $application = new Application($kernel);

        $this->createDepartment = $application->find('payroll:hire-worker');
        $this->commandTester = new CommandTester($this->createDepartment);
    }

    public function testWorkerHiredSuccess(): void
    {
        $this->ensureDepartmentExists();

        $this->commandTester->execute([
            'command' => $this->createDepartment->getName(),
            'first-name' => 'Mick',
            'last-name' => 'Mayers',
            'department-id' => DepartmentMother::ID,
            'salary' => 2500,
        ]);
        $output = $this->commandTester->getDisplay();

        self::assertStringContainsString('Worker hired!', $output);
    }

    private function ensureDepartmentExists(): void
    {
        /** @var Departments $departments */
        $departments = self::$container->get(Departments::class);

        $departments->add(DepartmentMother::random());
    }
}
