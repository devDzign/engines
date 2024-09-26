<?php

namespace App\Core\Workflow;

use App\Core\Engines\EngineInterface;

interface InterInvestWorkflowInterface
{
    public function start(): mixed;

    public function withArgs(?array $arguments = null): self;


}