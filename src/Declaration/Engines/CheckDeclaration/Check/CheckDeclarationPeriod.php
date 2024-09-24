<?php

namespace App\Declaration\Engines\CheckDeclaration\Check;

use App\Core\Engines\EngineInterface;
use App\Declaration\Exception\DeclarationErrorException;
use App\Declaration\Model\Declaration;


final class CheckDeclarationPeriod extends AbstractCheckDeclaration
{

    private EngineInterface $nextEngine;

    public function execute( mixed ...$args): Declaration
    {
        $declaration = $args[0];

        dd($declaration);

        assert($declaration instanceof Declaration);

        $period    = $declaration->period;
        $startDate = $declaration->startDate;
        $endDate   = $declaration->endDate;

        if (null === $declaration->period) {
            throw new DeclarationErrorException('Period is required');
        }


        if ($startDate > $endDate) {
            throw new DeclarationErrorException('Start date must be before end date');
        }

        $dateDiff = $startDate->diff($endDate);
        if ($dateDiff->m > $period) {
            throw new DeclarationErrorException('Period must be less than the difference between start and end date');
        }

        if ($this->nextEngine) {
            $this->nextEngine->execute($declaration);
        }

        return $declaration;
    }

    public function setNext(EngineInterface $engine): void
    {
        $this->nextEngine = $engine;
    }
}