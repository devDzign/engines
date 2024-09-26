<?php

namespace App\Controller;

use App\Process\Workflow\ActivityWorkflow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class TotoController extends AbstractController
{
    #[Route('/', name: 'app_test')]
    public function index(
       ActivityWorkflow $workflow,
    ): JsonResponse
    {

        $message = $workflow->start('Start');

        return $this->json(
            $message
        );
    }
}
