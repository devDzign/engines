<?php

namespace App\Logger\Engines;

use App\Core\Engines\AbstractEngines;
use JetBrains\PhpStorm\NoReturn;
use Psr\Log\LoggerInterface;

class ErrorLogger extends AbstractEngines
{

    public function __construct(protected LoggerInterface $logger) { }

    #[NoReturn]
    public function execute(mixed ...$args): string
    {
        $message = 'Error - '.$args[0];

        assert(is_string($message));
        $this->logger->error('Error: ' . $message);

        if (isset($this->nextEngine)) {
             return $this->nextEngine->execute($message);
        }

        return $message;

    }
}