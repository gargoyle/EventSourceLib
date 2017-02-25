<?php

namespace Pmc\EventSourceLib;

/**
 * @author Paul Court <emails@paulcourt.co.uk>
 */
class EventName extends \Pmc\ObjectLib\BasicString
{

    public function __construct(string $value)
    {
        parent::__construct($value, false, 512);
    }

}
