<?php

namespace App\Core\Workflow;

use App\Core\Engines\EngineInterface;

use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class AbstractInterInvestWorkflow implements InterInvestWorkflowInterface
{

    public function __construct(
        #[AutowireLocator(EngineInterface::class, defaultIndexMethod: 'supports')]
        protected ServiceLocator $locator,
        protected MessageBusInterface $eventBus
    ) {
    }

    public function make(string $className): EngineInterface
    {
        if (!$this->locator->has($className)) {
            throw new \Exception("The class $className does not exist in the container");
        }

        return $this->locator->get($className);
    }

    public function start(...$arguments): mixed
    {
        if (method_exists($this, 'execute')) {
            // Si la méthode existe, on l'exécute avec les paramètres passés
            return $this->execute(...$arguments);
        }
        // Si la méthode n'existe pas, on lève une exception ou on retourne un message d'erreur
        throw new \Exception('La méthode "execute" n\'existe pas dans la classe enfant.');
    }

}