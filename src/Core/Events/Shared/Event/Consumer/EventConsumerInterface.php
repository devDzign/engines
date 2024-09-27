<?php

namespace App\Core\Events\Shared\Event\Consumer;

use App\Core\Events\Shared\Event\EventInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
interface EventConsumerInterface extends EventInterface
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
