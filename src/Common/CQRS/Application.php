<?php

declare(strict_types=1);

namespace App\Common\CQRS;

use App\Common\Calendar\Clock;
use App\Common\CQRS\Exception\CommandException;
use Psr\Log\LoggerInterface;
use Throwable;

final class Application
{
    private CommandBus $commandBus;
    private Clock $clock;
    private LoggerInterface $logger;

    public function __construct(CommandBus $commandBus, Clock $clock, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->clock = $clock;
        $this->logger = $logger;
    }

    public function execute(Command $command): void
    {
        try {
            $this->commandBus->dispatch($command);
        } catch (Throwable $exception) {
            $error = CommandException::whenCannotHandleCommand($command, $exception);

            $this->logger->error(
                $error->getMessage(),
                [
                    'exception' => \get_class($exception),
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                    'occurred_at' => (string) $this->clock->now(),
                ]
            );

            throw $error;
        }
    }
}
