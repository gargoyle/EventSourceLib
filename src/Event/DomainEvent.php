<?php

namespace Pmc\EventSourceLib\Event;

use Pmc\ObjectLib\Id;
use Pmc\ObjectLib\Serializable\ArraySerializable;

/**
 * @author Gargoyle <g@rgoyle.com>
 */
interface DomainEvent extends ArraySerializable
{
    public function getEventId(): Id;
    public function getTimestamp(): float;
}
