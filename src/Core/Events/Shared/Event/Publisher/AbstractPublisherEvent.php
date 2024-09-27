<?php

namespace App\Core\Events\Shared\Event\Publisher;

abstract class AbstractPublisherEvent implements EventPublisherInterface
{
    public string $id;
    /** @var array<mixed, mixed> */
    public array $data;
    public string $eventName = self::EVENT_NAME;

    /**
     * @param array<mixed, mixed> $data
     */
    public function create(
        string $id,
        array $data,
    ): self {
        $this->id = $id;
        $this->data = $data;
        $this->eventName = static::EVENT_NAME;

        return $this;
    }
}
