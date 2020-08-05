<?php

declare(strict_types=1);

namespace App\Tests\Common\TestDouble\Domain;

use App\Common\Domain\AggregateRoot;
use App\Common\Domain\Event;

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
