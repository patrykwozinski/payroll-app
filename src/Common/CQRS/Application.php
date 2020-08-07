<?php

declare(strict_types=1);

namespace App\Common\CQRS;

use App\Common\Calendar\Clock;
use App\Common\CQRS\Exception\CommandException;
use App\Common\CQRS\Exception\QueryException;
use Psr\Log\LoggerInterface;
use Throwable;

final class Application
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;
    private Clock $clock;
    private LoggerInterface $logger;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus, Clock $clock, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->clock = $clock;
        $this->logger = $logger;
    }

    /** @throws CommandException */
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
                    'occurred_at' => (string)$this->clock->now(),
                ]
            );

            throw $error;
        }
    }

    /** @throws QueryException */
    public function query(string $name): Query
    {
        return $this->queryBus->getQuery($name);
    }
}
