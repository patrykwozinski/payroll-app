<?php

declare(strict_types=1);

namespace App\Common\Domain;

abstract class AggregateRoot
{
    /** @var Event[] */
    private array $events;

    final protected function recordThat(Event $event): void
    {
        $this->events[] = $event;
    }

    final public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
