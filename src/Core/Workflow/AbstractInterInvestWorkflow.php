<?php

namespace App\Core\Workflow;

use App\Core\Engines\EngineInterface;

use BadMethodCallException;
use Exception;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;

abstract class AbstractInterInvestWorkflow implements InterInvestWorkflowInterface
{

    public function __construct(
        #[AutowireLocator(EngineInterface::class, defaultIndexMethod: 'supports')]
        protected ServiceLocator $locator,

    ) {
    }


    /**
     * @template T of EngineInterface
     * @param class-string<T> $className
     * @throws Exception
     */
    public function make(string $className): EngineInterface
    {
        if (!$this->locator->has($className)) {
            throw new BadMethodCallException("The class $className does not exist in the container");
        }

        return $this->locator->get($className);
    }

    public function start(...$arguments): mixed
    {
        if (!method_exists($this, 'execute')) {
            throw new BadMethodCallException('Execute method not implemented.');
        }

        return $this->execute(...$arguments);
    }

}