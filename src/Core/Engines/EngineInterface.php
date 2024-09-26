<?php

namespace App\Core\Engines;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
interface EngineInterface
{

    public function start(): mixed;
    public static function supports(): string;
}