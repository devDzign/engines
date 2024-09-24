<?php

namespace App\Core\Workflow;

interface InterInvestWorkflowInterface
{

    /**
     * Performs the workflow process with the given arguments.
     *
     * @param mixed ...$args The arguments for the workflow process.
     * @return mixed The result of the workflow process.
     */
    public function run(mixed ...$args): mixed;

    public function engines(): iterable;

}