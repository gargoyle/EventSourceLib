<?php

namespace Pmc\EventSourceLib\Event;

use Pmc\ObjectLib\Id;

/**
 * Envelope to wrap a domain event which belongs to a certain "stream". For example,
 * all the events for a particular aggregate root.
 * 
 * @author Gargoyle <g@rgoyle.com>
 */
class StreamEvent
{

    /**
     * @var DomainEvent
     */
    private $event;

    /**
     * @var int
     */
    private $sequence;

    /**
     * @var Id
     */
    private $streamId;

    public function __construct(Id $streamId, int $sequence, DomainEvent $event)
    {
        $this->streamId = $streamId;
        $this->sequence = $sequence;
        $this->event = $event;
    }

    public function getEvent(): DomainEvent
    {
        return $this->event;
    }

    public function getSequence(): int
    {
        return $this->sequence;
    }

    public function getStreamId(): Id
    {
        return $this->streamId;
    }

}
