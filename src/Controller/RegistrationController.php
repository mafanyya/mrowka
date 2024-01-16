<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'api_register')]
    public function index(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $entityManager)
    {
        $data =json_decode($request->getContent(), true);
        if($data){
            $email = $data['email'];
            $plainPassword = $data['password'];
            $name = $data['name'];
            $avatar = $data['avatar'];
            $user = new User();
            $user-> setEmail($email);
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user ->setPassword($hashedPassword);
            $user->setName($name);
            $user->setAvatar($avatar);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json(['message' => 'Registration successful']);

        }
        return 'register/api';
    }
}