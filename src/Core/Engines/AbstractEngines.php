<?php

namespace App\Core\Engines;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
abstract class AbstractEngines implements EngineInterface
{
    protected EngineInterface $nextEngine;

    public function setNext(EngineInterface $engine): void
    {
        $this->nextEngine = $engine;
    }
    public static function supports(): string
    {
        return static::class;
    }
}