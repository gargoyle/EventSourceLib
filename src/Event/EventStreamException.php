<?php

namespace Pmc\EventSourceLib\Event;

use InvalidArgumentException;

/**
 * Thrown by the EventStream class when invalid StreamEvents are used.
 * 
 * @author Gargoyle <g@rgoyle.com>
 */
class EventStreamException extends InvalidArgumentException
{
}
