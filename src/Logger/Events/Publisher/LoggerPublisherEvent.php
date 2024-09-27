<?php

namespace App\Logger\Events\Publisher;

use App\Core\Events\Shared\Event\Publisher\AbstractPublisherEvent;

class LoggerPublisherEvent extends AbstractPublisherEvent
{
    public const EVENT_NAME = 'logger.event';
}
