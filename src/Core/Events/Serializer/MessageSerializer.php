<?php

declare(strict_types=1);

namespace App\Core\Events\Serializer;


use App\Core\Events\Shared\Event\Consumer\EventConsumerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class MessageSerializer implements SerializerInterface
{

    public function __construct(
        #[Autowire(service: 'messenger.transport.symfony_serializer')]
        private SerializerInterface $serializer,
        #[AutowireLocator(EventConsumerInterface::class, defaultIndexMethod: 'support')]
        protected ServiceLocator $locator,


    ) {
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];

        if (empty($body)) {
            throw new MessageDecodingFailedException('Encoded envelope should have at least a "body" and some "headers", or maybe you should implement your own serializer.');
        }

        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        if($this->locator->has($data['eventName'])) {
            $message = $this->locator->get($data['eventName']);
            $message->create($data['id'], $data['data'], $data['eventName']);
            $encodedEnvelope['body'] = json_encode($message, JSON_THROW_ON_ERROR);
            $encodedEnvelope['headers']['type'] = get_class($message);
        }


        $envelope = $this->serializer->decode($encodedEnvelope);

        return $envelope;
    }

    public function encode(Envelope $envelope): array
    {
        return $this->serializer->encode($envelope);
    }
}