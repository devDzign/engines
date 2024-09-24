<?php

namespace App\Declaration\Workflow;

use App\Core\Workflow\AbstractInterInvestWorkflow;
use App\Declaration\Engines\CheckDeclaration\Check\CheckDeclarationPeriod;
use App\Declaration\Engines\CheckDeclaration\Check\CheckFormulaireMillesimeExiste;

class DeclarationCreatedWorkflow extends AbstractInterInvestWorkflow
{
    public function engines(): iterable
    {
        return
            [
                CheckDeclarationPeriod::class,
                CheckFormulaireMillesimeExiste::class,
            ];
    }

}