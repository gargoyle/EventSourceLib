<?php

namespace Pmc\EventSourceLib\Event;

use Countable;
use Iterator;
use Pmc\ObjectLib\Id;

/**
 * Represent a list of StreamEvents which all must be from the same stream.
 * 
 * @author Gargoyle <g@rgoyle.com>
 */
class EventStream implements Countable, Iterator
{

    /**
     * @var Id
     */
    private $streamId;
    
    /**
     * @var array
     */
    private $eventList;
    
    /**
     * @var int
     */
    private $arrayPointer;

    public function __construct(Id $streamId)
    {
        $this->streamId = $streamId;
        $this->eventList = [];
        $this->rewind();
    }

    public function addEvent(StreamEvent $event): void
    {
        if (!$event->getStreamId()->equals($this->streamId)) {
            throw new EventStreamException("Event does not belong to this stream!");
        }
        $this->eventList[] = $event;
    }
    
    public function getStreamId(): Id
    {
        return $this->streamId;
    }

    public function count(): int
    {
        return count($this->eventList);
    }

    public function current(): StreamEvent
    {
        return $this->eventList[$this->arrayPointer];
    }

    public function key()
    {
        return $this->arrayPointer;
    }

    public function next(): void
    {
        $this->arrayPointer++;
    }

    public function rewind(): void
    {
        $this->arrayPointer = 0;
    }

    public function valid(): bool
    {
        return isset($this->eventList[$this->arrayPointer]);
    }

}
