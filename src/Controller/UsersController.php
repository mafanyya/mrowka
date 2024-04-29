<?php

namespace App\Controller;

use DateTime;
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
    #[Route('/api/users/find-me', name: 'api_users_find_me')]
    public function findMe(UserRepository $userRepository, Request $request)
    {
        $data = json_decode($request->getContent(), associative: true);
        $uniqId = $data['data']['user']['uniqid'];
        $user = $userRepository->findOneByUniqId($uniqId);

        return $this->json([
            'data' => $data,
            'user' => $user
            ]);
    }
    #[Route('/api/users/find', name: 'api_users_find')]
    public function find(UserRepository $userRepository, Request $request)
    {
        $data = json_decode($request->getContent(), associative: true);
        $uniqid = $data['uniqid'];
        $user = $userRepository->findOneByUniqId($uniqid);
        return $this->json(['user' => $user]);
    }
    #[Route('/api/user/edit', name: 'api_user_edit')]
    public function edit(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $uniqid = $data['uniqid'];
        $email = $data['email'];
        $name = $data['name'];
        $avatar = $data['avatar'];
        $user = $userRepository->findOneByUniqId($uniqid);
        $user->setEmail($email);
        $user->setName($name);
        $user->setAvatar($avatar);
        $entityManager->persist($user);
        $entityManager->flush();


        return $this->json(['message' => 'User successfully edited', 'user' => $user]);
    }
    #[Route('/api/user/psw-upgrade', name: 'api_user_psw_upgrade')]
    public function upgradePassword(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $data = json_decode($request->getContent(), associative: true);
        $uniqid = $data['uniqid'];
        $plainPassword = $data['password'];
        $user = $userRepository->findOneByUniqId($uniqid);
        $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
        $userRepository->upgradePassword($user, $hashedPassword);

        return $this->json(['message' => 'Password successful upgrade']);
    }
    #[Route('/api/user/psw-check', name: 'api_user_psw_check')]
    public function passwordCheck(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $data = json_decode($request->getContent(), associative: true);
        $uniqid = $data['uniqid'];
        $password = $data['password'];

        $user = $userRepository->findOneByUniqId($uniqid);
        $isPswValid = $userPasswordHasher->isPasswordValid($user, $password);


        return $this->json(['isPswValid' => $isPswValid]);
    }

    #[Route('/api/user/delete', name: 'api_user_delete')]
    public function delete(UserRepository $userRepository, Request $request,)
    {
        $data = json_decode($request->getContent(), associative: true);
        $uniqId = $data['uniqid'];

        $user = $userRepository->findOneByUniqId($uniqId);
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

    /**
     * @throws \Exception
     */
    #[Route('/api/users/count', name: 'api_users_count')]
    public function countUsers(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        $usersCount = count($users);
        $allOnlineCount = count($userRepository->findAllOnline());
        $adminsOnlineCount = count($userRepository->findOnlineAdmins());
        $usersOnlineCount = count($userRepository->findOnlineUsers());

        $nowDateTime = new DateTime(date("Y-m-d H:i:s"));


        $todayDateTime = clone $nowDateTime;
        $todayDateTime->modify('-1 day');
        $todayDateTime->format('Y-m-d H:i:s');

        $lastWeekDateTime = clone $nowDateTime;
        $lastWeekDateTime->modify('-1 week');
        $lastWeekDateTime->format('Y-m-d H:i:s');

        $usersToday = count($userRepository->findRegisteredUsersByTime($todayDateTime));
        $usersLastWeek = count($userRepository->findRegisteredUsersByTime($lastWeekDateTime));

        if($usersToday == null){
            $usersToday = 0;
        }
        if($usersLastWeek == null){
            $usersLastWeek = 0;
        }

        return $this->json([
            'last_week_time' => $lastWeekDateTime,
            'today_time' => $todayDateTime,
            'users_count' => $usersCount,
            'all_online_count' => $allOnlineCount,
            'admins_online_count' => $adminsOnlineCount,
            'users_online_count' => $usersOnlineCount,
            'users_today' => $usersToday,
            'users_last_week' => $usersLastWeek
            ]);

    }

}