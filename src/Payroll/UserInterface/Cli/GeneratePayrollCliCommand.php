<?php

declare(strict_types=1);

namespace App\Payroll\UserInterface\Cli;

use App\Common\Calendar\Date;
use App\Common\CQRS\Application;
use App\Payroll\Application\Command\GeneratePayroll\GeneratePayrollCommand;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GeneratePayrollCliCommand extends Command
{
    private const OPTION_DATE = 'date';

    protected static $defaultName = 'payroll:generate';

    private Application $application;

    public function __construct(Application $application)
    {
        parent::__construct(self::$defaultName);

        $this->application = $application;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generates payroll for current workers')
            ->addArgument(self::OPTION_DATE, InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $inputDate */
        $inputDate = $input->getArgument(self::OPTION_DATE);
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d', $inputDate);
        $io = new SymfonyStyle($input, $output);

        if (false === $dateTime instanceof DateTimeImmutable) {
            $io->error('Invalid date format - required: "Y-m-d"');

            return 1;
        }

        $date = new Date($dateTime);
        $payrollId = Uuid::uuid4()->toString();

        $command = new GeneratePayrollCommand(
            $payrollId,
            $date
        );

        $this->application->execute($command);

        $io->success(
            sprintf('Payroll generated successfully. ID: %s', $payrollId)
        );

        return 0;
    }
}
