<?php

namespace App\Declaration\Engines\CheckDeclaration\Check;

use App\Declaration\Exception\DeclarationErrorException;
use App\Declaration\Model\Declaration;


final class CheckDeclarationPeriod extends AbstractCheckDeclaration
{

    /**
     * @throws DeclarationErrorException
     */

    public function execute(mixed ...$args): Declaration
    {
        $declaration = $args[0];

        assert($declaration instanceof Declaration);
        dd($declaration);
        $period = $declaration->period;
        $startDate = $declaration->startDate;
        $endDate = $declaration->endDate;

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

        return $declaration;
    }


}