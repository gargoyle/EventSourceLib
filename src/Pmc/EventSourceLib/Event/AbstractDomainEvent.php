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

    public function getEventId(): EventId
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

    public static function fromArray(array $data)
    {
        $instance = new static();
        $instance->eventId = Id::fromString($data['eventId']);
        $instance->timestamp = (float) $data['timestamp'];
        return $instance;
    }
}
