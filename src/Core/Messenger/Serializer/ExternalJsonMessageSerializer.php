<?php

namespace App\Core\Messenger\Serializer;

use App\Core\Messenger\Events\ErrorEvent;
use App\Core\Messenger\Shared\Event\EventInInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;
use Symfony\Component\Messenger\Stamp\SerializedMessageStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

class ExternalJsonMessageSerializer implements SerializerInterface
{
    public const string MESSENGER_SERIALIZATION_CONTEXT = 'messenger_serialization';

    private const string STAMP_HEADER_PREFIX = 'X-Message-Stamp-';
    // private const CONTEXT = [];

    public function __construct(
        #[AutowireLocator(EventInInterface::class, defaultIndexMethod: 'support')]
        private readonly ServiceLocator $serviceLocator,
        private readonly SymfonySerializerInterface $serializer,
        private readonly MessageBusInterface $eventBus,
    ) {}

    /**
     * @param array<string, mixed> $encodedEnvelope
     *
     * @throws \JsonException
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        if (empty($encodedEnvelope['body']) || empty($encodedEnvelope['headers'])) {
            throw new MessageDecodingFailedException('Encoded envelope should have at least a "body" and some "headers", or maybe you should implement your own serializer.');
        }

        if (empty($encodedEnvelope['headers']['type'])) {
            throw new MessageDecodingFailedException('Encoded envelope does not have a "type" header.');
        }

        $stamps = $this->decodeStamps($encodedEnvelope);
        $stamps[] = new SerializedMessageStamp($encodedEnvelope['body']);

        try {
            $message = $this->createEnvelope(json_decode($encodedEnvelope['body'], true, 512, JSON_THROW_ON_ERROR));
        } catch (\Throwable $e) {
            return $this->eventBus->dispatch(new ErrorEvent($e->getMessage(), $encodedEnvelope));
        }

        return $message->with(...$stamps);
    }

    /**
     * @return array{body: string, headers: array<string, string>}
     */
    public function encode(Envelope $envelope): array
    {
        /** @var SerializedMessageStamp|null $serializedMessageStamp */
        $serializedMessageStamp = $envelope->last(SerializedMessageStamp::class);

        $envelope = $envelope->withoutStampsOfType(NonSendableStampInterface::class);

        $headers = ['type' => $envelope->getMessage()::class] + $this->encodeStamps($envelope);

        return [
            'body' => $serializedMessageStamp
                ? $serializedMessageStamp->getSerializedMessage()
                : $this->serializer->serialize($envelope->getMessage(), 'json', [self::MESSENGER_SERIALIZATION_CONTEXT => true]),
            'headers' => $headers,
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    public function createEnvelope(array $data): Envelope
    {
        if (!isset($data['eventName'])) {
            throw new MessageDecodingFailedException('Missing the eventName key!');
        }

        if (!$this->serviceLocator->has($data['eventName'])) {
            throw new \RuntimeException('Unknown event name');
        }

        $event = $this->serviceLocator->get($data['eventName']);

        if ($event instanceof EventInInterface) {
            $message = $event->create($data['id'], $data['data'], $data['eventName']);
        } else {
            throw new MessageDecodingFailedException('Unknown event name');
        }

        return new Envelope($message);
    }

    /**
     * @param array<string, mixed> $encodedEnvelope
     *
     * @return array<NonSendableStampInterface>
     */
    private function decodeStamps(array $encodedEnvelope): array
    {
        $stamps = [];
        foreach ($encodedEnvelope['headers'] as $name => $value) {
            if (!str_starts_with($name, self::STAMP_HEADER_PREFIX)) {
                continue;
            }

            try {
                $stamps[] = $this->serializer->deserialize($value, substr($name, \strlen(self::STAMP_HEADER_PREFIX)) . '[]', 'json', [self::MESSENGER_SERIALIZATION_CONTEXT => true]);
            } catch (ExceptionInterface $e) {
                throw new MessageDecodingFailedException('Could not decode stamp: ' . $e->getMessage(), $e->getCode(), $e);
            }
        }
        if ($stamps) {
            $stamps = array_merge(...$stamps);
        }

        return $stamps;
    }

    /**
     * @return array<string, string>
     */
    private function encodeStamps(Envelope $envelope): array
    {
        if (!$allStamps = $envelope->all()) {
            return [];
        }

        $headers = [];
        foreach ($allStamps as $class => $stamps) {
            $headers[self::STAMP_HEADER_PREFIX . $class] = $this->serializer->serialize($stamps, 'json', [self::MESSENGER_SERIALIZATION_CONTEXT => true]);
        }

        return $headers;
    }
}
