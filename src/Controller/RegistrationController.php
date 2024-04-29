<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/api/register', name: 'api_register')]
    public function index(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $entityManager)
    {
        $data =json_decode($request->getContent(), true);
        if($data){
            $email = $data['email'];
            $plainPassword = $data['password'];
            $name = $data['name'];
            $avatar = $data['avatar'];
            $roles = $data['roles'];
            $isAdmin = $data['isAdmin'];
            $lastSeen = new DateTimeImmutable(date("Y-m-d H:i:s"));
            $lastSeen->format('Y-m-d H:i:s');
            $registerTime = new DateTimeImmutable(date("Y-m-d H:i:s"));
            $registerTime->format('Y-m-d H:i:s');
            $uniqId = $this->uniqidGen();
            $status = $data['status'];

            $user = new User();
            $user-> setEmail($email);
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setRoles($roles);
            $user ->setPassword($hashedPassword);
            $user->setName($name);
            $user->setAvatar($avatar);
            $user->setStatus($status);
            $user->setLastseen($lastSeen);
            $user->setIsAdmin($isAdmin);
            $user->setUniqid($uniqId);
            $user->setRegisterAt($registerTime);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json([
                'message' => 'Registration successful',
                'user' => $uniqId
                ]);
        }
        return 'register/api';
    }
    public function uniqidGen($lenght = 13) {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}