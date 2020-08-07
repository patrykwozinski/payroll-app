<?php

declare(strict_types=1);

namespace App\Tests\Common\CQRS\Unit;

use App\Common\CQRS\Command;
use App\Common\CQRS\MessengerCommandCommandBus;
use App\Tests\Common\CQRS\ObjectMother\FakeCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBusTest extends TestCase
{
    private MessageBusInterface $symfonyMessageBus;
    private MessengerCommandCommandBus $commandBus;

    protected function setUp(): void
    {
        $this->symfonyMessageBus = $this->assembleSymfonyMessageBus();
        $this->commandBus = new MessengerCommandCommandBus($this->symfonyMessageBus);
    }

    public function testUsesMessageBusWhenDispatching(): void
    {
        $command = new FakeCommand();
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
