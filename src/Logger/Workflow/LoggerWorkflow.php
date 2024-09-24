<?php

namespace App\Logger\Workflow;

use App\Core\Workflow\AbstractInterInvestWorkflow;
use App\Logger\Engines\ErrorLogger;
use App\Logger\Engines\RapportLogger;
use App\Logger\Engines\WerningLogger;

class LoggerWorkflow extends AbstractInterInvestWorkflow
{

    public function engines(): iterable
    {
        return [
            ErrorLogger::class,
            WerningLogger::class,
            RapportLogger::class,
        ];
    }
}