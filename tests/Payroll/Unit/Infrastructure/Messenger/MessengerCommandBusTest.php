<?php

declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Infrastructure\Messenger;

use App\Common\Application\Command;
use App\Common\Infrastructure\Messenger\MessengerCommandBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBusTest extends TestCase
{
    private MessageBusInterface $symfonyMessageBus;
    private MessengerCommandBus $commandBus;

    protected function setUp(): void
    {
        $this->symfonyMessageBus = $this->assembleSymfonyMessageBus();
        $this->commandBus = new MessengerCommandBus($this->symfonyMessageBus);
    }

    public function testUsesMessageBusWhenDispatching(): void
    {
        $command = new class() implements Command {
        };
        $this->commandBus->dispatch($command);

        self::assertSame($command, $this->symfonyMessageBus->dispatchedCommand());
    }

    private function assembleSymfonyMessageBus(): MessageBusInterface
    {
        return new class() implements MessageBusInterface {
            private Command $dispatchedCommand;

            public function dispatch($message, array $stamps = []): Envelope
            {
                $this->dispatchedCommand = $message;

                return new Envelope($message);
            }

            public function dispatchedCommand(): Command
            {
                return $this->dispatchedCommand;
            }
        };
    }
}
