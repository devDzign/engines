<?php

namespace App\Core\Activities;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * @method mixed execute(...$arguments)
 */
#[AutoconfigureTag()]
interface ActivityInterface
{

    public function start(): mixed;
    public static function supports(): string;
}