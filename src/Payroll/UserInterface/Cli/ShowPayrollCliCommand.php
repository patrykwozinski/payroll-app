<?php

declare(strict_types=1);

namespace App\Payroll\UserInterface\Cli;

use App\Common\CQRS\Application;
use App\Payroll\Application\Query\PayrollQuery;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ShowPayrollCliCommand extends Command
{
    private const OPTION_PAYROLL_ID = 'payroll-id';

    protected static $defaultName = 'payroll:show';

    private Application $application;

    public function __construct(Application $application)
    {
        parent::__construct(self::$defaultName);

        $this->application = $application;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Shows payroll by given ID')
            ->addArgument(self::OPTION_PAYROLL_ID, InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $inputId */
        $inputId = $input->getArgument(self::OPTION_PAYROLL_ID);
        $payrollId = Uuid::fromString($inputId);
        $io = new SymfonyStyle($input, $output);

        /** @var PayrollQuery $payrollQuery */
        $payrollQuery = $this->application->query(PayrollQuery::class);
        $payrollQuery->ofId($payrollId);

        $io->success('OK');

        return 0;
    }
}
