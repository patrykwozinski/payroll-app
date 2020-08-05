<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Messenger;

use App\Common\Application\Command;
use App\Common\Application\Command\Bus;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements Bus
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
