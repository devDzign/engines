<?php

namespace App\Controller;


use App\Process\Workflow\Activity2Workflow;
use App\Process\Workflow\ActivityWorkflow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}
