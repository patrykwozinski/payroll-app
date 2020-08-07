<?php

declare(strict_types=1);

namespace App\Common\CQRS\Exception;

use App\Common\CQRS\Command;
use Exception;
use Throwable;

final class CommandException extends Exception
{
    public static function whenCannotHandleCommand(Command $command, Throwable $previousException): self
    {
        $message = \sprintf('Cannot handle command: %s ', \get_class($command));

        return new self($message, $previousException->getCode(), $previousException);
    }
}
