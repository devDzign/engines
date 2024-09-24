<?php

namespace App\Core\Messenger\Shared\Event;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
interface EventOutInterface extends EventInterface
{
    public const string EVENT_NAME = 'default.event';

    /**
     * @param array<mixed, mixed> $data
     *
     * @return static
     */
    public function create(string $id, array $data): self;
}
