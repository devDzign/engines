<?php

namespace App\Declaration\Engines\CheckDeclaration\Check;

use App\Declaration\Exception\DeclarationErrorException;
use App\Declaration\Model\Declaration;

final class CheckDeclaration  extends AbstractCheckDeclaration
{
    public function __construct(
        private CheckDeclarationPeriod $checkDeclarationPeriod,
        private CheckFormulaireMillesimeExiste $checkFormulaireMillesimeExiste,
    ) {
    }

    /**
     * @throws DeclarationErrorException
     */
    public function execute(mixed ...$declaration): Declaration
    {
        $declaration = $declaration[0];

        assert($declaration instanceof Declaration);

        return  $this->checkFormulaireMillesimeExiste->execute(
            $this->checkDeclarationPeriod->execute($declaration)
        );;
    }


}