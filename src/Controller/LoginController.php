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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Config\LexikJwtAuthentication\TokenExtractors\AuthorizationHeaderConfig;


class LoginController extends AbstractController
{

    #[Route('/api/users/me', name: 'api_users_me')]
    public function getCredential():Response
    {
        $user = $this->getUser();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $data = $serializer->serialize($user, 'json');
        $userData = json_decode($data, true);


        return $this->json([
            'user' => $userData
        ]);
    }

    #[Route('/api/logout', name: 'api_logout')]
    public function logout(Request $request, RefreshToken $refreshToken):Response
    {
        return $this->json(['status' => 'OK']);

    }

}