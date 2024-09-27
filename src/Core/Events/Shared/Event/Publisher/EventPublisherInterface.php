<?php

namespace App\Core\Events\Shared\Event\Publisher;

use App\Core\Events\Shared\Event\EventInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
interface EventPublisherInterface extends EventInterface
{
    public const EVENT_NAME = 'default.event';

    /**
     * @param array<mixed, mixed> $data
     *
     * @return static
     */
    public function create(
        string $id,
        array $data,
    ): self;
}
