<?php

namespace Pmc\EventSourceLib\Command;

use Pmc\ {
    EventSourceLib\Aggregate\AggregateId,
    Session\Session
};


/**
 * @author Gargoyle <g@rgoyle.com>
 */
interface AggregateCommand
{
    public function aggregateId(): AggregateId;
    public function session(): Session;
}
