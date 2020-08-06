<?php

declare(strict_types=1);

namespace App\Payroll\Application\Command\GenerateReport;

use App\Common\Application\Command\Handler;

final class GenerateReportHandler implements Handler
{
    public function __invoke(GenerateReportCommand $command): void
    {
    }
}
