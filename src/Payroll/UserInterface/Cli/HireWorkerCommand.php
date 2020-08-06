<?php

declare(strict_types=1);

namespace App\Payroll\UserInterface\Cli;

use App\Common\Application\Command\Bus;
use App\Payroll\Application\Command\HireWorker\HireWorkerCommand as HireWorker;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class HireWorkerCommand extends Command
{
    private const OPTION_FIRST_NAME = 'first-name';
    private const OPTION_LAST_NAME = 'last-name';
    private const OPTION_DEPARTMENT_ID = 'department-id';
    private const OPTION_SALARY = 'salary';

    protected static $defaultName = 'payroll:hire-worker';

    private Bus $commandBus;

    public function __construct(Bus $commandBus)
    {
        parent::__construct(self::$defaultName);

        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Hires given worker')
            ->addArgument(self::OPTION_FIRST_NAME, InputArgument::REQUIRED)
            ->addArgument(self::OPTION_LAST_NAME, InputArgument::REQUIRED)
            ->addArgument(self::OPTION_DEPARTMENT_ID, InputArgument::REQUIRED)
            ->addArgument(self::OPTION_SALARY, InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $firstName */
        $firstName = $input->getArgument(self::OPTION_FIRST_NAME);
        /** @var string $lastName */
        $lastName = $input->getArgument(self::OPTION_LAST_NAME);
        /** @var string $departmentId */
        $departmentId = $input->getArgument(self::OPTION_DEPARTMENT_ID);
        /** @var string $salary */
        $salary = $input->getArgument(self::OPTION_SALARY);

        $workerId = Uuid::uuid4()->toString();
        $command = new HireWorker(
            $workerId,
            $firstName,
            $lastName,
            $departmentId,
            (int) $salary
        );

        $this->commandBus->dispatch($command);

        $io->success(
            \sprintf('Worker hired! ID: %s', $workerId)
        );

        return 0;
    }
}
