<?php

declare(strict_types=1);

namespace App\Common\CQRS\Exception;

use Exception;

final class QueryException extends Exception
{
    public static function whenNotFound(string $queryName): self
    {
        $message = \sprintf('Query not found: %s ', $queryName);

        return new self($message);
    }
}
