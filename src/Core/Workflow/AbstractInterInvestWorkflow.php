<?php

namespace App\Core\Workflow;

use App\Core\Engines\EngineInterface;

use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;

abstract class AbstractInterInvestWorkflow implements InterInvestWorkflowInterface
{

    protected ?array $arguments = null;

    public function __construct(
        #[AutowireLocator(EngineInterface::class, defaultIndexMethod: 'supports')]
        protected ServiceLocator $locator,
    ) {
    }

    public function make(string $className): EngineInterface
    {

        if(!$this->locator->has($className)){

            throw new \Exception("The class $className does not exist in the container");
        }

        return $this->locator->get($className);

    }

    public function withArgs(?array $arguments = null): self
    {
        $this->arguments = $arguments;

        return $this;
    }


    public function getArguments(): array
    {
        return $this->arguments;
    }

}