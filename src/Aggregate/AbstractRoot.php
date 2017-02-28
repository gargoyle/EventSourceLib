<?php

namespace Pmc\EventSourceLib\Aggregate;

use Pmc\EventSourceLib\Event\ {
    AggregateEvent,
    AggregateEventList
};
use RuntimeException;


/**
 * Base aggregate root which contains common functionality which 
 * other roots can extend for a head start.
 *
 * @author Paul Court <emails@paulcourt.co.uk>
 */
abstract class AbstractRoot
{
    protected $seq = 0;
    protected $id = null;
    
    
    public function __construct(AggregateEventList $events)
    {
        $this->applyEvents($events);
    }
    
    
    public function handleCommand($command): AggregateEventList
    {
        $classname = get_class($command);
        $methodName = 'handle' . substr(
                $classname, 
                strrpos($classname, '\\') + 1) . 'Command';
        
        if (!method_exists($this, $methodName)) {
            throw new RuntimeException(sprintf(
                    "Command handler method not found: %s!",
                    $methodName));
        }
        
        $events = new AggregateEventList();
        $events->addEvents($this->$methodName($command));
        $this->applyEvents($events);
        return $events;
    }
    
    private function applyEvents(AggregateEventList $events)
    {
        foreach ($events as $event) {
            $this->applyEvent($event);
        }
    }
    

    private function applyEvent(AggregateEvent $event)
    {
        if ($this->id == null) {
            $this->id = $event->aggregateId();
        }
        
        if (((string)$event->aggregateId() !== (string)$this->id)) {
            throw new RuntimeException(sprintf(
                    "Event ID missmatch! %s %s",
                    $event->aggregateId(),
                    $this->id));
        }
        
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
