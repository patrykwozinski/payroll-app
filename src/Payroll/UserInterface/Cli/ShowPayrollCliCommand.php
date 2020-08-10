<?php

declare(strict_types=1);

namespace App\Payroll\UserInterface\Cli;

use App\Common\CQRS\Application;
use App\Payroll\Application\Query\PayrollFilter;
use App\Payroll\Application\Query\PayrollQuery;
use App\Payroll\Application\Query\PayrollSorter;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ShowPayrollCliCommand extends Command
{
    private const OPTION_PAYROLL_ID = 'payroll-id';
    private const OPTION_SORT_FIELD = 'sort-field';
    private const OPTION_SORT_DIRECTION = 'sort-direction';

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
            ->addArgument(self::OPTION_PAYROLL_ID, InputArgument::REQUIRED)
            ->addOption(self::OPTION_SORT_FIELD, 'sf', InputOption::VALUE_OPTIONAL)
            ->addOption(self::OPTION_SORT_DIRECTION, 'sd', InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $inputId */
        $inputId = $input->getArgument(self::OPTION_PAYROLL_ID);
        $payrollId = Uuid::fromString($inputId);

        /** @var string|null $sortingField */
        $sortingField = $input->getOption(self::OPTION_SORT_FIELD);
        /** @var string|null $sortingDirection */
        $sortingDirection = $input->getOption(self::OPTION_SORT_DIRECTION);

        $sorter = PayrollSorter::default();

        if ($sortingField && $sortingDirection) {
            $sorter = new PayrollSorter($sortingField, $sortingDirection);
        }

        $filter = PayrollFilter::create()
            ->withSorter($sorter);

        /** @var PayrollQuery $payrollQuery */
        $payrollQuery = $this->application->query(PayrollQuery::class);
        $payroll = $payrollQuery->find($payrollId, $filter);

        if (null === $payroll) {
            $io->error('Payroll with given ID not found');

            return 1;
        }

        $tableRows = [];
        foreach ($payroll->records() as $record) {
            $tableRows[] = [
                $record->firstName(),
                $record->lastName(),
                $record->department(),
                $record->salary(),
                $record->salaryBonus(),
                $record->bonusType(),
                $record->totalSalary(),
            ];
        }

        $io->section(\sprintf('Payroll ID %s generated at: %s', $payroll->id(), $payroll->generatedAt()));
        $table = new Table($output);
        $table
            ->setHeaders(['First name', 'Last name', 'Department', 'Salary', 'Salary bonus', 'Bonus type', 'Total salary'])
            ->setRows($tableRows);
        $table->render();

        return 0;
    }
}
