<?php

namespace App\Declaration\Engines\CheckDeclaration\Check;

use App\Declaration\Engines\CheckDeclaration\Common\CheckDeclarationInterface;

abstract class AbstractCheckDeclaration implements CheckDeclarationInterface
{

    public static function supports(): string
    {
        return static::class;
    }

}