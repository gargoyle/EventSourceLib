<?php

namespace Pmc\EventSourceLib\Event;

use Pmc\{
    EventSourceLib\Aggregate\AggregateId,
    Session\Session
};

/**
 * @author Paul Court <emails@paulcourt.co.uk>
 */
abstract class AbstractEvent implements AggregateEvent
{

    private $aggregateId;
    private $session;
    private $eventId;
    private $timestamp;

    public function __construct(Session $session, AggregateId $aggregateId)
    {
        $this->session = $session;
        $this->aggregateId = $aggregateId;
        $this->eventId = new EventId();
        $this->timestamp = microtime(true);
    }

    public function aggregateId(): AggregateId
    {
        return $this->aggregateId;
    }

    public function eventId(): EventId
    {
        return $this->eventId;
    }

    public function timestamp(): float
    {
        return $this->timestamp;
    }

    public function session()
    {
        return $this->session;
    }

    public function toArray(): array
    {
        return [
            'eventId' => (string) $this->eventId(),
            'aggregateId' => (string) $this->aggregateId(),
            'timestamp' => $this->timestamp(),
            'session' => $this->session->toArray()
        ];
    }

    public static function fromArray(array $data)
    {
        $instance = new static();
        $instance->eventId = EventId::fromString($data['eventId']);
        $instance->aggregateId = AggregateId::fromString($data['aggregateId']);
        $instance->timestamp = (float) $data['timestamp'];
        $instance->session = Session::fromArray($data['session']);
        return $instance;
    }

}
