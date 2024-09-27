<?php

declare(strict_types=1);

namespace App\Core\Events\Shared\Event\Common;

use App\Core\Events\Shared\Event\Consumer\AbstractConsumerEvent;

class WorkflowConsumer extends AbstractConsumerEvent
{
    public const string EVENT_NAME = 'workflow.event';

}