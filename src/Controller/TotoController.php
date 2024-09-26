<?php

namespace App\Controller;

use App\Declaration\Model\Declaration;

use App\Declaration\Workflow\DeclarationCreatedWorkflow;
use App\Logger\Workflow\LoggerWorkflow;
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
