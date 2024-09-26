<?php

namespace App\Core\Workflow;

use App\Core\Engines\EngineInterface;

use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;

abstract class AbstractInterInvestWorkflow implements InterInvestWorkflowInterface
{

    protected array $arguments = [];

    public function __construct(
        #[AutowireLocator(EngineInterface::class, defaultIndexMethod: 'supports')]
        protected ServiceLocator $locator,
    ) {
    }

    public function loadEngine(string $className): EngineInterface
    {

        if(!$this->locator->has($className)){

            throw new \Exception("The class $className does not exist in the container");
        }

        return $this->locator->get($className);

    }

    abstract public function withArgs(mixed ...$arguments): array;


    public function getArguments(): array
    {
        return $this->arguments;
    }

}