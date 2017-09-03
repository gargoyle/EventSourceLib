<?php

namespace Pmc\EventSourceLib\Aggregate;

use Pmc\EventSourceLib\Event\DomainEvent;
use Pmc\EventSourceLib\Event\EventStream;
use Pmc\EventSourceLib\Event\StreamEvent;
use RuntimeException;


/**
 * Base aggregate root which contains common functionality which other roots can 
 * extend for a head start.
 *
 * @author Gargoyle <g@rgoyle.com>
 */
abstract class AbstractRoot
{
    protected $seq = 0;
    protected $id = null;
    
    protected $pendingEvents;
    
    public function __construct(EventStream $events)
    {
        $this->id = $events->getStreamId();
        $this->pendingEvents = new EventStream($this->id);
        $this->applyEvents($events);
    }
    
    protected function raise(DomainEvent $event)
    {
        $this->applyEvent($event);
        $this->pendingEvents->addEvent(new StreamEvent($this->id, $this->seq, $event));
    }
    
    protected function applyEvents(EventStream $events)
    {
        foreach ($events as $event) {
            $this->applyEvent($event->getEvent());
        }
    }

    protected function applyEvent(DomainEvent $event)
    {
        $methodName = 'apply' . substr(
                get_class($event), 
                strrpos(get_class($event), '\\') + 1) . 'Event';
        
        if (!method_exists($this, $methodName)) {
            throw new RuntimeException(sprintf(
                    "Non-existant method: %s when processing aggregate root event",
                    $methodName));
        }
        
        $this->$methodName($event);
        $this->seq++;
    }
}
