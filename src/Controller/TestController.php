<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/api/test', name: 'app_test')]
    public function index(): JsonResponse
    {
    $data = ['message' => 'Hello from !',
    'name' => 'Bob'];
    return new JsonResponse($data);

    }
}
