<?php

namespace Pmc\EventSourceLib\Storage;

use Pmc\EventSourceLib\Event\EventStream;
use Pmc\EventSourceLib\Event\StreamEvent;
use Pmc\MessageBus\MessageBus;
use Pmc\ObjectLib\ClassMap;
use Pmc\ObjectLib\Id;

/**
 * EventStore does two things:-
 * 
 *      1.) Store a stream of events
 *      2.) Fetch a stream of events
 * 
 * @author Gargoyle <g@rgoyle.com>
 */
abstract class EventStore
{

    /**
     * @var ClassMap
     */
    private $eventNameMapper;

    /**
     * @var MessageBus
     */
    private $messageBus;

    /**
     * @var StorageEngine
     */
    private $storageEngine;

    
    public function __construct(StorageEngine $storageEngine, MessageBus $messageBus, ClassMap $eventNameMapper)
    {
        $this->storageEngine = $storageEngine;
        $this->messageBus = $messageBus;
        $this->eventNameMapper = $eventNameMapper;
    }

    protected abstract function getMetaData(): array;
    
    public function store(EventStream $events): void
    {
        foreach ($events as $streamEvent) {
            /* @var $streamEvent StreamEvent */
            $domainEvent = $streamEvent->getEvent();
            $eventRecord = [
                'eventId' => (string)$domainEvent->getEventId(),
                'eventName' => (string)$this->eventNameMapper->getNameForClass(get_class($domainEvent)),
                'eventData' => json_encode($domainEvent->toArray()),
                'streamId' => (string)$streamEvent->getStreamId(),
                'streamSeq' => $streamEvent->getSequence(),
                'storedAt' => microtime(true),
                'metaData' => json_encode($this->getMetaData())
            ];
            $this->storageEngine->storeSerializedEvent($eventRecord);
        }
    }

    public function getStream(Id $streamId): EventStream
    {
        $eventStream = new EventStream($streamId);
        $rawStream = $this->storageEngine->getSerialisedStream($streamId);
        foreach ($rawStream as $serialisedEventRecord) {
            $domainEventClass = $this->eventNameMapper->getClassForName($serialisedEventRecord['eventName']);
            $domainEvent = $domainEventClass::fromArray(json_decode($serialisedEventRecord['eventData']));
            $streamEvent = new StreamEvent($serialisedEventRecord['streamId'], $serialisedEventRecord['streamSeq'], $domainEvent);
            $eventStream->addEvent($streamEvent);
        }
        return $eventStream;
    }

}
