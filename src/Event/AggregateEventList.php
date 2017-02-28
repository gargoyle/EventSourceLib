<?php

namespace Pmc\EventSourceLib\Event;

use Iterator;

/**
 * @author Gargoyle <g@rgoyle.com>
 */
class AggregateEventList implements Iterator
{
    private $eventList;
    private $index;
    
    public function __construct()
    {
        $this->eventList = [];
        $this->index = 0;
    }
    
    public function addEvents(AggregateEventList $events)
    {
        foreach ($events as $event) {
            $this->addEvent($event);
        }
    }
    
    public function addEvent(AggregateEvent $event)
    {
        $this->eventList[] = $event;
    }

    public function current(): AggregateEvent
    {
        return $this->eventList[$this->index];
    }

    public function key(): \scalar
    {
        return $this->index;
    }

    public function next(): void
    {
        $this->index++;
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function valid(): bool
    {
        return isset($this->eventList[$this->index]);
    }
}
