<?php

namespace App\Core\Messenger\Shared\Event;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
interface EventInInterface extends EventInterface
{
    public const string EVENT_NAME = 'default.event';

    public static function support(): string;

    /**
     * @param array<mixed, mixed> $data
     *
     * @return static
     */
    public function create(
        string $id,
        array $data,
        string $eventName = self::EVENT_NAME,
    ): self;
}
