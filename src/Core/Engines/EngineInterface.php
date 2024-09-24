<?php

namespace App\Core\Engines;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
interface EngineInterface
{
    public function execute(mixed ...$arg):mixed;
    public function setNext(EngineInterface $engine): void;
    public static function supports(): string;
}