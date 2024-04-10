<?php

namespace App\Controller;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class UsersController extends AbstractController
{


    #[Route('/api/users', name: 'api_users')]
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->json(['users' => $users]);
    }

    #[Route('/api/user/delete', name: 'api_user_delete')]
    public function delete(UserRepository $userRepository, Request $request,)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $user = $userRepository->find($id);
        $name = $user->getName();
        $userRepository->remove($user);

        return $this->json(['name' => $name]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/api/user/log_out', name: 'api_user_log_out')]
    public function logOut(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $lastSeen = new \Monolog\DateTimeImmutable(date("Y-m-d H:i:s"));
        $lastSeen->format('Y-m-d H:i:s');
        $user = $userRepository->find($id);
        $user->setStatus(false);
        $status = $user->isStatus();
        $user->setLastseen($lastSeen);
        $entityManager->persist($user);
        $entityManager->flush();


        return $this->json(['status' => $status]);
    }
    #[Route('/api/user/log_in', name: 'api_user_log_in')]
    public function logIn(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $user = $userRepository->find($id);
        $user->setStatus(true);
        $status = $user->isStatus();
        $entityManager->persist($user);
        $entityManager->flush();


        return $this->json(['status' => $status]);
    }

    #[Route('/api/users/count', name: 'api_users_count')]
    public function countUsers(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        $usersCount = count($users);
        $allOnlineCount = count($userRepository->findAllOnline());
        $adminsOnlineCount = count($userRepository->findOnlineAdmins());
        $usersOnlineCount = count($userRepository->findOnlineUsers());

        return $this->json([
            'users_count' => $usersCount,
            'all_online_count' => $allOnlineCount,
            'admins_online_count' => $adminsOnlineCount,
            'users_online_count' => $usersOnlineCount
            ]);

    }
}