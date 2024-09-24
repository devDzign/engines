<?php

namespace App\Declaration\Engines\CheckDeclaration\Check;




use App\Declaration\Exception\DeclarationErrorException;
use App\Declaration\Model\Declaration;



final class CheckFormulaireMillesimeExiste extends AbstractCheckDeclaration
{

    /**
     * @throws DeclarationErrorException
     */
        public function execute(mixed ...$declaration): Declaration
    {
        $declaration = $declaration[0];

        assert($declaration instanceof Declaration);
        $millesime = $declaration->millesime;
        $formulaire = $declaration->formulaire;

        if (null === $declaration->millesime) {
            throw new DeclarationErrorException('Millesime is required');
        }

        if (null === $declaration->formulaire) {
            throw new DeclarationErrorException('Formulaire is required');
        }

        $dictionnaire = null; // get dictionnaire from database
        if (null === $dictionnaire) {
            throw new DeclarationErrorException('Millesime does not exist');
        }

        return $declaration;
    }
}