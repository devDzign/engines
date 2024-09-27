<?php

namespace App\Logger\Events\Consumer;

use App\Logger\Workflow\LoggerWorkflow;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
readonly class LoggerInHandler
{

    public function __construct(protected LoggerWorkflow $workflow) { }

    public function __invoke(LoggerEvent $event): void
    {
        echo $this->workflow->start($event->eventName).' 🇩🇿 '.PHP_EOL;
    }
}
