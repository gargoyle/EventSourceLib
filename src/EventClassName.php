<?php

namespace Pmc\EventSourceLib;

/**
 * @author Gargoyle <g@rgoyle.com>
 */
class EventClassName extends \Pmc\ObjectLib\BasicString
{
    public function __construct(string $value)
    {
        parent::__construct($value, false, 255);
    }

}
