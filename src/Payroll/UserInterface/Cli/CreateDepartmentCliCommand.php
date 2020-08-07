<?php

declare(strict_types=1);

namespace App\Payroll\UserInterface\Cli;

use App\Common\CQRS\Application;
use App\Payroll\Application\Command\CreateDepartment\CreateDepartmentCommand;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class CreateDepartmentCliCommand extends Command
{
    private const OPTION_NAME = 'name';
    private const OPTION_BONUS_TYPE = 'bonus-type';
    private const OPTION_BONUS_VALUE = 'bonus-value';

    protected static $defaultName = 'payroll:create-department';

    private Application $application;

    public function __construct(Application $application)
    {
        parent::__construct(self::$defaultName);

        $this->application = $application;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates the department')
            ->addArgument(self::OPTION_NAME, InputArgument::REQUIRED)
            ->addArgument(self::OPTION_BONUS_TYPE, InputArgument::REQUIRED)
            ->addArgument(self::OPTION_BONUS_VALUE, InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $name */
        $name = $input->getArgument(self::OPTION_NAME);
        /** @var string $bonusType */
        $bonusType = $input->getArgument(self::OPTION_BONUS_TYPE);
        /** @var string $bonusValue */
        $bonusValue = $input->getArgument(self::OPTION_BONUS_VALUE);

        $departmentId = Uuid::uuid4()->toString();
        $command = new CreateDepartmentCommand(
            $departmentId,
            $name,
            $bonusType,
            (int) $bonusValue
        );

        $this->application->execute($command);

        $io->success(
            \sprintf('Created department! ID: %s', $departmentId)
        );

        return 0;
    }
}
