<?php

namespace Pmc\EventSourceLib\Command;

use Pmc\Session\Session;
use Psr\Log\LoggerInterface;

/**
 * @author Paul Court <emails@paulcourt.co.uk>
 */
abstract class AbstractFactory
{
    private $session;
    private $logger;

    public function __construct(Session $session, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->session = $session;
    }
    
    protected function requiredKeys(array $data, array $keys)
    {
        foreach ($keys as $key) {
            if (!in_array($key, array_keys($data))) {
                throw new BadCommandDataException(sprintf(
                        'Input data does not contain required parameter: %s.', 
                        implode(', ', $keys)));
            }
        }
    }
}
