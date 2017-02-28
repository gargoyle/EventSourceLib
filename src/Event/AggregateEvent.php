<?php

namespace Pmc\EventSourceLib\Event;

use Pmc\ {
    EventSourceLib\Aggregate\AggregateId,
    ObjectLib\Serializable\ArraySerializable,
    Session\Session
};

/**
 * @author Gargoyle <g@rgoyle.com>
 */
interface AggregateEvent extends ArraySerializable
{
    public function eventId(): EventId;
    public function aggregateId(): AggregateId;
    public function timestamp(): float;
    public function session(): Session;
}
