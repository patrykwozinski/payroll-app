<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Error;

use App\Payroll\Domain\DepartmentId;
use Exception;

final class DepartmentNotFound extends Exception
{
    public static function withId(DepartmentId $departmentId): self
    {
        $message = sprintf('Department with ID: "%s" not found', $departmentId);

        return new self($message);
    }
}
