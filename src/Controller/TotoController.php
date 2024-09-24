<?php

namespace App\Controller;

use App\Declaration\Model\Declaration;

use App\Declaration\Workflow\DeclarationCreatedWorkflow;
use App\Logger\Workflow\LoggerWorkflow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class TotoController extends AbstractController
{
    #[Route('/', name: 'app_test')]
    public function index(
        DeclarationCreatedWorkflow $createdWorkflow,
        LoggerWorkflow $loggerWorkflow
    ): JsonResponse
    {
        $declaration = (new Declaration('1'));
        $message = $loggerWorkflow->run('MON MESSAGE');


//        $createdWorkflow->run($declaration);

        return $this->json(
            $message
        );
    }
}
