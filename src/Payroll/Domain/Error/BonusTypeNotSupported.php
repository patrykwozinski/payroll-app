<?php

declare(strict_types=1);

namespace App\Payroll\Domain\Error;

final class BonusTypeNotSupported extends \Exception
{
    public static function whenIs(string $type): self
    {
        $message = \sprintf('Given bonus type is not supported: %s', $type);

        return new self($message);
    }
}
