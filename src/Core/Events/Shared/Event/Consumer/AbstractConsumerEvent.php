<?php

namespace App\Core\Events\Shared\Event\Consumer;

abstract class AbstractConsumerEvent implements EventConsumerInterface
{
    public string $id;
    /** @var array<mixed, mixed> */
    public array $data;
    public string $eventName;

    /**
     * @param array<mixed, mixed> $data
     */
    final public function create(
        string $id,
        array $data,
        string $eventName = self::EVENT_NAME,
    ): self {
        $this->id = $id;
        $this->data = $data;
        $this->eventName = $eventName;

        return $this;
    }

    public static function support(): string
    {
        return static::EVENT_NAME;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array<mixed, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }
}
