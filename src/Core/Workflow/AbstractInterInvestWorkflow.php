<?php

namespace App\Core\Workflow;

use App\Core\Engines\EngineInterface;

use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;

abstract class AbstractInterInvestWorkflow implements InterInvestWorkflowInterface
{
    protected EngineInterface $engineExecution;
    public function __construct(
        #[AutowireLocator(EngineInterface::class, defaultIndexMethod: 'supports')]
        protected ServiceLocator $locator,
    ) { }

    public function run(mixed ...$args): mixed
    {
        foreach ($this->engines() as $key => $engine) {

            $engine = $this->locator->get($engine);

            if($key+1 === count($this->engines())) {
                return $this->engineExecution->execute(...$args);
            }

            $engine->setNext($this->locator->get($this->engines()[$key+1]));

            if($key === 0) {
                $this->engineExecution = $engine;
            }
        }
    }

}