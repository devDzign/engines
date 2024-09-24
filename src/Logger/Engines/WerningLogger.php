<?php

namespace App\Logger\Engines;

use App\Core\Engines\AbstractEngines;
use Psr\Log\LoggerInterface;

class WerningLogger extends AbstractEngines
{

    public function __construct(protected LoggerInterface $logger) { }

    public function execute(mixed ...$arg): string
    {
        $message = 'Warning - '. $arg[0];
        assert(is_string($message));
        $this->logger->info('Report: ' . $message);

        if ($this->nextEngine) {
            return $this->nextEngine->execute($message);
        }

        return $message;
    }

}