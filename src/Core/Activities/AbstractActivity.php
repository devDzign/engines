<?php

namespace App\Core\Activities;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
abstract class AbstractActivity implements ActivityInterface
{

    public function start(...$arguments): mixed
    {
        if (!method_exists($this, 'execute')) {
            throw new \BadMethodCallException('Execute method not implemented.');
        }

        // Si la méthode existe, on l'exécute avec les paramètres passés
        return $this->execute(...$arguments);
    }

    public static function supports(): string
    {
        return static::class;
    }
}