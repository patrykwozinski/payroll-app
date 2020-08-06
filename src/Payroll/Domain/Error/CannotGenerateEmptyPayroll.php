<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Error;

use App\Common\Date;
use Exception;

final class CannotGenerateEmptyPayroll extends Exception
{
    public static function forDate(Date $date): self
    {
        $message = \sprintf('Can not generate payroll report for specific date: %s', $date);

        return new self($message);
    }
}
