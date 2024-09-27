<?php

namespace App\Core\Workflow;

/**
 * @method mixed execute(...$arguments)
 */
interface IIWorkflowInterface
{
    public function start(): mixed;

}