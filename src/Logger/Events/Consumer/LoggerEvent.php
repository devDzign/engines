<?php

namespace App\Logger\Events\Consumer;

use App\Core\Events\Shared\Event\Consumer\AbstractConsumerEvent;

class LoggerEvent extends AbstractConsumerEvent
{
    public const string EVENT_NAME = 'logger.event';
}
