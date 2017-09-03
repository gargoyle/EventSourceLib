<?php

namespace Pmc\EventSourceLib\Event;

use Pmc\ObjectLib\Id;

/**
 * @author Gargoyle <g@rgoyle.com>
 */
abstract class AbstractDomainEvent implements DomainEvent
{
    protected $eventId;
    protected $timestamp;

    public function __construct()
    {
        $this->eventId = new Id();
        $this->timestamp = microtime(true);
    }

    public function getEventId(): Id
    {
        return $this->eventId;
    }

    public function getTimestamp(): float
    {
        return $this->timestamp;
    }

    public function toArray(): array
    {
        return [
            'eventId' => (string) $this->eventId,
            'timestamp' => $this->timestamp
        ];
    }

    protected function updateFromArray(array $data)
    {
        $this->eventId = Id::fromString($data['eventId']);
        $this->timestamp = (float) $data['timestamp'];
    }
}
