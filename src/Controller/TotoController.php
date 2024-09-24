<?php

namespace App\Controller;

use App\Declaration\Workflow\DeclarationCreatedWorkflow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class TotoController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DeclarationCreatedWorkflow $createdWorkflow): JsonResponse
    {
        $declaration = (new \stdClass());
        $createdWorkflow->run($declaration);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TotoController.php',
        ]);
    }
}
