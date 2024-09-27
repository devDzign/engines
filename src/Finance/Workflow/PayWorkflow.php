<?php

declare(strict_types=1);

namespace App\Finance\Workflow;

use App\Core\Workflow\AbstractIIWorkflow;
use App\Finance\Activities\CheckCardActivity;

class PayWorkflow extends AbstractIIWorkflow
{
    public const string WORKFLOW_NAME = 'pay.workflow';

    public function execute(): string
    {
        // Appel de l'activité depuis le workflow
        $response = $this->make(CheckCardActivity::class)->execute();

        // Implémentation du workflow ici
        return $response;
    }
}
