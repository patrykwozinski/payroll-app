<?php

declare(strict_types=1);

namespace App\Payroll\UserInterface\Cli;

use App\Common\Application\Command\Bus;
use App\Common\Date;
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
    protected static $defaultName = 'payroll:generate-payroll';

    private Bus $commandBus;

    public function __construct(Bus $commandBus)
    {
        parent::__construct(self::$defaultName);

        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generates payroll for current workers')
            ->addArgument('date', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $inputDate */
        $inputDate = $input->getArgument('date');
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d', $inputDate);
        $io = new SymfonyStyle($input, $output);

        if (false === $dateTime instanceof DateTimeImmutable) {
            $io->error('Invalid date format - required: "Y-m-d"');

            return 1;
        }

        $date = new Date($dateTime);

        $command = new GeneratePayrollCommand(
            Uuid::uuid4()->toString(),
            $date
        );

        $this->commandBus->dispatch($command);

        $io->success('Payroll generated successfully, yo!');

        return 0;
    }
}
