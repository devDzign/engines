<?php

namespace App\Core\Events\Shared\Event\Common;

use App\Logger\Events\Consumer\LoggerEvent;
use App\Logger\Workflow\LoggerWorkflow;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
readonly class WorkflowConsumerHandler
{

    public function __construct(protected LoggerWorkflow $workflow) { }

    public function __invoke(LoggerEvent $event): void
    {
        echo $this->workflow->start($event->eventName).' 🇩🇿 '.PHP_EOL;
    }
}
