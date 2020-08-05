<?php

declare(strict_types=1);

namespace App\Tests\Common\Unit\Domain;

use App\Common\Domain\Event;
use App\Tests\Common\TestDouble\Domain\StubAggregateRoot;
use PHPUnit\Framework\TestCase;

final class AggregateRootTest extends TestCase
{
    private StubAggregateRoot $aggregate;
    private Event $event;

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = new class() implements Event {
        };
        $this->aggregate = StubAggregateRoot::recordingEvent($this->event);
    }

    public function testRecordsEvents(): void
    {
        $this->aggregate->action();
        $events = $this->aggregate->pullEvents();
        self::assertCount(1, $events);
        self::assertSame($this->event, $events[0]);
    }

    public function testPullingEventsFlushesThem(): void
    {
        $this->aggregate->action();
        $this->aggregate->pullEvents();
        $pulledAgainEvents = $this->aggregate->pullEvents();
        self::assertCount(0, $pulledAgainEvents);
    }
}
