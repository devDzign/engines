<?php

declare(strict_types=1);

namespace App\Logger\Workflow;

use App\Core\Workflow\AbstractIIWorkflow;
use App\Logger\Activities\LoggerActivity;

class LoggerWorkflow extends AbstractIIWorkflow
{
    public function execute(string $message = 'Init'): string
    {
        return $this->make(LoggerActivity::class)->execute($message);
    }

}