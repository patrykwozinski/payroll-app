<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Error;

use Exception;

final class DepartmentNameIsTaken extends Exception
{
    public static function withName(string $name): self
    {
        $message = \sprintf('Given department name is taken: %s', $name);

        return new self($message);
    }
}
