<?php

namespace Pmc\EventSourceLib\Command;

use Pmc\ {
    EventSourceLib\Aggregate\AggregateId,
    Session\Session
};

/**
 * @author Gargoyle <g@rgoyle.com>
 */
abstract class AbstractCommand implements AggregateCommand
{

    /**
     * @var AggregateId
     */
    private $aggregateId;

    /**
     * @var Session
     */
    private $session;

    public function __construct(AggregateId $aggregateId, Session $session)
    {
        $this->aggregateId = $aggregateId;
        $this->session = $session;
    }

    public function session(): Session
    {
        return $this->session;
    }

    public function aggregateId(): AggregateId
    {
        return $this->aggregateId;
    }

}
