<?php

namespace App\Logger\Engines;

use App\Core\Engines\AbstractEngines;
use Psr\Log\LoggerInterface;

class RapportLogger extends AbstractEngines
{

    public function __construct(protected LoggerInterface $logger) { }

    public function execute(mixed ...$arg): string
    {
        $message = 'Report - '.$arg[0];
        assert(is_string($message));
        $this->logger->error('Report: ' . $message);

        if (isset($this->nextEngine)) {
           return  $this->nextEngine->execute($message);
        }
        return $message;

    }

}