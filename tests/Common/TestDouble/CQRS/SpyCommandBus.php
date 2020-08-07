<?php

declare(strict_types=1);

namespace App\Tests\Common\TestDouble\CQRS;

use App\Common\CQRS\Command;
use App\Common\CQRS\CommandBus;
use Throwable;

final class SpyCommandBus implements CommandBus
{
    private ?Command $dispatchedCommand = null;
    private ?Throwable $exceptionToRaise = null;

    public static function working(): self
    {
        return new self();
    }

    public static function failing(Throwable $throwable): self
    {
        $bus = new self();
        $bus->exceptionToRaise = $throwable;

        return $bus;
    }

    public function dispatch(Command $command): void
    {
        if (null !== $this->exceptionToRaise) {
            throw $this->exceptionToRaise;
        }

        $this->dispatchedCommand = $command;
    }

    public function wasDispatched(Command $command): bool
    {
        return $this->dispatchedCommand === $command;
    }
}
