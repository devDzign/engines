<?php

namespace App\Core\Workflow;

use App\Core\Engines\EngineInterface;

interface InterInvestWorkflowInterface
{
    public function start(mixed ...$args): mixed;

    public function loadEngine(string $className): EngineInterface;

}