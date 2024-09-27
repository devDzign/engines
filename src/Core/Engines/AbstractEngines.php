<?php

namespace App\Core\Engines;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
abstract class AbstractEngines implements EngineInterface
{

    public function start(...$arguments): mixed
    {
        if (method_exists($this, 'execute')) {
            // Si la méthode existe, on l'exécute avec les paramètres passés
            return $this->execute(...$arguments);
        }
        // Si la méthode n'existe pas, on lève une exception ou on retourne un message d'erreur
        throw new \Exception('La méthode "execute" n\'existe pas.');
    }

    public static function supports(): string
    {
        return static::class;
    }
}