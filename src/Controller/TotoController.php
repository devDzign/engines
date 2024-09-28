<?php

namespace App\Controller;


use App\Logger\Events\Publisher\LoggerPublisherEvent;
use App\Process\Workflow\Activity2Workflow;
use App\Process\Workflow\ActivityWorkflow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class TotoController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/', name: 'app_test')]
    public function index(
        Activity2Workflow $workflow,
        ActivityWorkflow $w
    ): JsonResponse
    {
        return $this->json(
            $workflow->start(
                $w->start('Start')
            )
        );
    }


    /**
     * @throws \Exception
     */
    #[Route('/event', name: 'app_event')]
    public function event(
      MessageBusInterface $eventBus,
    ): JsonResponse
    {

        $message = (new LoggerPublisherEvent())->create(
            '123',
            [
                'message' => 'Hello World',
            ]
        );

        $eventBus->dispatch($message, [new AmqpStamp('default')]);
        return $this->json(
          $message
        );
    }

}
