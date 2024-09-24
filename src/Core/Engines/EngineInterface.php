<?php

namespace App\Core\Engines;
use App\Core\Model\EngineModelInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
interface EngineInterface
{

    public function execute(mixed ...$arg):mixed;
    public static function supports(): string;
}