<?php

namespace App\Declaration\Engines\CheckDeclaration\Check;




use App\Core\Engines\AbstractEngines;
use App\Core\Engines\EngineInterface;
use App\Declaration\Exception\DeclarationErrorException;
use App\Declaration\Model\Declaration;



final class CheckFormulaireMillesimeExiste extends AbstractEngines
{

    /**
     * @throws DeclarationErrorException
     */
        public function execute(mixed ...$args): Declaration
    {
        $declaration = $args[0];

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

    public function setNext(EngineInterface $engine): void
    {
        $this->nextEngine = $engine;
    }
}