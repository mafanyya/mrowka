<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\RefreshToken;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Config\LexikJwtAuthentication\TokenExtractors\AuthorizationHeaderConfig;


class LoginController extends AbstractController
{

    #[Route('/api/users/me', name: 'api_users_me')]
    public function getCredential():Response
    {
        $user = $this->getUser();
        return $this->json([
            'user' => $user
        ]);
    }

    #[Route('/api/logout', name: 'api_logout')]
    public function logout(Request $request, RefreshToken $refreshToken):Response
    {
        return $this->json(['status' => 'OK']);

    }

}