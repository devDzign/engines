<?php

namespace App\Core\Workflow;

use App\Core\Engines\EngineInterface;

use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;

abstract class AbstractInterInvestWorkflow implements InterInvestWorkflowInterface
{
    public function __construct(
        #[AutowireLocator(EngineInterface::class, defaultIndexMethod: 'supports')]
        protected ServiceLocator $locator,
    ) { }

    public function run(mixed ...$args): array
    {
        foreach ($this->engines() as $engine) {
            $engine = $this->locator->get($engine);
            $engine->execute(...$args);
        }
    }

}