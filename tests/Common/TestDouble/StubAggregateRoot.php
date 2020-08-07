<?php

declare(strict_types=1);

namespace App\Tests\Common\TestDouble;

use App\Common\EventDriven\AggregateRoot;
use App\Common\EventDriven\Event;

final class StubAggregateRoot extends AggregateRoot
{
    private Event $event;

    public static function recordingEvent(Event $event): self
    {
        $instance = new self();
        $instance->event = $event;

        return $instance;
    }

    public function action(): void
    {
        $this->recordThat($this->event);
    }
}
