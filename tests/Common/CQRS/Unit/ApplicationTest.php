<?php

declare(strict_types=1);

namespace App\Tests\Common\CQRS\Unit;

use App\Common\Calendar\Clock\FixedClock;
use App\Common\Calendar\Date;
use App\Common\CQRS\Application;
use App\Common\CQRS\Exception\CommandException;
use App\Tests\Common\CQRS\ObjectMother\FakeCommand;
use App\Tests\Common\CQRS\TestDouble\SpyCommandBus;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class ApplicationTest extends TestCase
{
    private FixedClock $fixedClock;
    private NullLogger $nullLogger;

    protected function setUp(): void
    {
        $this->fixedClock = FixedClock::on(new Date(new DateTimeImmutable('2020-01-03')));
        $this->nullLogger = new NullLogger();
    }

    public function testCommandSuccessfullyExecutedWhenApplicationWorks(): void
    {
        // Given
        $command = new FakeCommand();
        $commandBus = SpyCommandBus::working();
        $application = new Application($commandBus, $this->fixedClock, $this->nullLogger);

        // When
        $application->execute($command);

        // Then
        self::assertTrue($commandBus->wasDispatched($command), 'Command should be dispatched');
    }

    public function testExecutingCommandFailedWhenRaisedError(): void
    {
        // Given
        $command = new FakeCommand();
        $occurringException = new InvalidArgumentException('OMG!');
        $expectedException = CommandException::whenCannotHandleCommand($command, $occurringException);
        $commandBus = SpyCommandBus::failing($occurringException);
        $application = new Application($commandBus, $this->fixedClock, $this->nullLogger);

        // Expect
        $this->expectExceptionObject($expectedException);

        // When
        $application->execute($command);

        // Then
        self::assertFalse($commandBus->wasDispatched($command), 'Command should not be dispatched');
    }
}
