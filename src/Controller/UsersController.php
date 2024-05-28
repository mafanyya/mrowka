<?php

namespace App\Controller;

use App\Repository\AchievementRepository;
use App\Repository\LessonRepository;
use App\Repository\LessonSectionRepository;
use App\Repository\TestRepository;
use App\Repository\WordRepository;
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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class UsersController extends AbstractController
{


    #[Route('/api/users', name: 'api_users')]
    public function index(UserRepository $userRepository, WordRepository $wordRepository, LessonRepository $lessonRepository,
                         LessonSectionRepository $lessonSectionRepository, AchievementRepository $achievementRepository,
                         TestRepository $testRepository, Request $request):Response
    {
        $users = $userRepository->findAll();
        $usersArray = [];

        foreach ($users as $user){
            $userId = $user->getId();
            $words = $wordRepository->findWordsByUser($userId);
            $wordsArray = [];
            $sectionsArray = [];
            foreach ($words as $word){
                $sectionsArray[] = [
                    'id' => $word->getLesson()->getLessonSection()->getId()
                ];

                $wordsArray[] = [
                    'id' => $word->getId(),
                    'name' => $word->getName(),
                    'translation' => $word->getTranslation(),
                    'img' => $word->getLesson()->getImg(),
                    'lessonUniqid' => $word->getLesson()->getUniqid(),
                    'lessonId' => $word->getLesson()->getId(),
                    'sectionId' => $word->getLesson()->getLessonSection()->getId(),

                ];
            }
            $achievementsArray = [];
            $achievements = $achievementRepository->findAchievementsByUser($userId);
            foreach ($achievements as $achievement){
                $achievementsArray[] = [
                    'id' => $achievement->getId(),
                    'title' => $achievement->getTitle(),
                    'uniqid' => $achievement->getUniqid(),
                    'img' => $achievement->getImg()
                ];
            }

            $testsArray = [];
            $tests = $testRepository->findtestsByUser($userId);
            foreach ($tests as $test){
                $testsArray[] = [
                    'id' => $test->getId(),
                    'title' => $test->getTitle(),
                    'uniqid' => $test->getUniqid(),
                ];
            }

            $sectionsArray = [];
            $sections = $lessonSectionRepository->findSectionsByUser($userId);
            foreach ($sections as $section){
                $sectionsArray[] = [
                    'id' => $section->getId(),
                    'title' => $section->getTitle(),
                    'uniqid' => $section->getUniqid(),
                ];
            }

            $lessonsArray = [];
            $lessons = $lessonRepository->findLessonsByUser($userId);
            foreach ($lessons as $lesson){
                $lessonsArray[] = [
                    'id' => $lesson->getId(),
                    'title' => $lesson->getTitle(),
                    'uniqid' => $lesson->getUniqid(),
                ];
            }

            $userData = [];
            $userData = [
                'id' => $user->getId(),
                'uniqid' => $user->getUniqid(),
                'email' => $user->getEmail(),
                'name' =>$user->getName(),
                'avatar' => $user->getAvatar(),
                'password' => $user->getPassword(),
                'lastSeen' => $user->getLastseen(),
                'registeredAt' => $user->getRegisterAt(),
                'roles' => $user->getRoles(),
                'status' => $user->isStatus(),
                'isAdmin' => $user->isIsAdmin(),
                'achievements' => $achievementsArray,
                'lessons' => $lessonsArray,
                'sections' => $sectionsArray,
                'tests' => $testsArray,
                'words' => $wordsArray
            ];

            $usersArray[] = [
                'user' => $userData
            ];
        }

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $encodeData = $serializer->serialize($usersArray, 'json');

        $usersData = json_decode($encodeData, true);

        return $this->json(['users' => $usersData]);
    }

    #[Route('/api/users/find', name: 'api_users_find')]
    public function find(UserRepository $userRepository, WordRepository $wordRepository, LessonRepository $lessonRepository,
                         LessonSectionRepository $lessonSectionRepository, AchievementRepository $achievementRepository,
                         TestRepository $testRepository, Request $request):Response
    {
        $data = json_decode($request->getContent(), associative: true);
        $uniqid = $data['uniqid'];
        $user = $userRepository->findOneByUniqId($uniqid);

        $userId = $user->getId();
        $words = $wordRepository->findWordsByUser($userId);
        $wordsArray = [];
        $sectionsArray = [];
        foreach ($words as $word){
            $sectionsArray[] = [
                'id' => $word->getLesson()->getLessonSection()->getId()
            ];

            $wordsArray[] = [
                'id' => $word->getId(),
                'name' => $word->getName(),
                'translation' => $word->getTranslation(),
                'img' => $word->getLesson()->getImg(),
                'lessonUniqid' => $word->getLesson()->getUniqid(),
                'lessonId' => $word->getLesson()->getId(),
                'sectionId' => $word->getLesson()->getLessonSection()->getId(),

            ];
        }
        $achievementsArray = [];
        $achievements = $achievementRepository->findAchievementsByUser($userId);
        foreach ($achievements as $achievement){
            $achievementsArray[] = [
                'id' => $achievement->getId(),
                'title' => $achievement->getTitle(),
                'uniqid' => $achievement->getUniqid(),
                'img' => $achievement->getImg()
            ];
        }

        $testsArray = [];
        $tests = $testRepository->findtestsByUser($userId);
        foreach ($tests as $test){
            $testsArray[] = [
                'id' => $test->getId(),
                'title' => $test->getTitle(),
                'uniqid' => $test->getUniqid(),
            ];
        }

        $sectionsArray = [];
        $sections = $lessonSectionRepository->findSectionsByUser($userId);
        foreach ($sections as $section){
            $sectionsArray[] = [
                'id' => $section->getId(),
                'title' => $section->getTitle(),
                'uniqid' => $section->getUniqid(),
            ];
        }

        $lessonsArray = [];
        $lessons = $lessonRepository->findLessonsByUser($userId);
        foreach ($lessons as $lesson){
            $lessonsArray[] = [
                'id' => $lesson->getId(),
                'title' => $lesson->getTitle(),
                'uniqid' => $lesson->getUniqid(),
            ];
        }

        $userData = [];
        $userData = [
            'id' => $user->getId(),
            'uniqid' => $user->getUniqid(),
            'email' => $user->getEmail(),
            'name' =>$user->getName(),
            'avatar' => $user->getAvatar(),
            'password' => $user->getPassword(),
            'lastSeen' => $user->getLastseen(),
            'registeredAt' => $user->getRegisterAt(),
            'roles' => $user->getRoles(),
            'status' => $user->isStatus(),
            'isAdmin' => $user->isIsAdmin(),
            'achievements' => $achievementsArray,
            'lessons' => $lessonsArray,
            'sections' => $sectionsArray,
            'tests' => $testsArray,
            'words' => $wordsArray
        ];

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $data = $serializer->serialize($userData, 'json');
        $userDataValue = json_decode($data, true);


        return $this->json([
            'user' => $userDataValue,
            'test' => 'test'
        ]);
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


        return $this->json(['message' => 'User successfully edited']);
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
        $usersAllCount = count($users);
        $allOnlineCount = count($userRepository->findAllOnline());
        $adminsOnlineCount = count($userRepository->findOnlineAdmins());
        $usersOnlineCount = count($userRepository->findOnlineUsers());
        $usersCount = count($userRepository->findUsers());
        $adminsCount = count($userRepository->findAdmins());

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
            'users_count' => $usersAllCount,
            'all_online_count' => $allOnlineCount,
            'admins_online_count' => $adminsOnlineCount,
            'users_online_count' => $usersOnlineCount,
            'users_today' => $usersToday,
            'users_last_week' => $usersLastWeek,
            'admins_count' => $adminsCount,
            'users_count_users' => $usersCount
            ]);

    }

    #[Route('/api/add-word-user', name: 'api_add_word_user')]
    public function addWordUser(UserRepository $userRepository, WordRepository $wordRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $wordId = $data['wordId'];
        $userId = $data['userId'];

        $user = $userRepository->find($userId);
        $word = $wordRepository->find($wordId);

        $user->addWord($word);
        $wordName = $word->getName();

        $entityManager->persist($user);
        $entityManager->flush();


        return $this->json(['wordName' => $wordName]);
    }

    #[Route('/api/remove-word-user', name: 'api_remove_word_user')]
    public function removeWordUser(UserRepository $userRepository, WordRepository $wordRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $wordId = $data['wordId'];
        $userId = $data['userId'];

        $user = $userRepository->find($userId);
        $word = $wordRepository->find($wordId);

        $user->removeWord($word);
        $wordName = $word->getName();

        $entityManager->persist($user);
        $entityManager->flush();


        return $this->json(['wordName' => $wordName]);
    }

    #[Route('/api/add-lesson-user', name: 'api_add_lesson_user')]
    public function addLessonUser(UserRepository $userRepository, WordRepository $wordRepository, TestRepository $testRepository, LessonRepository $lessonRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $testId = $data['testId'];
        $userId = $data['userId'];

        $test = $testRepository->find($testId);
        $user = $userRepository->find($userId);

        $lesson = $test->getLesson();
        $achievements = $lesson->getAchievements();
        foreach ($achievements as $achievement) {
            $user->addAchievement($achievement);
        }
        $section = $lesson->getLessonSection();

        $user->addTest($test);
        $user->addLesson($lesson);
        $user->addSection($section);

        $testTitle = $test->getTitle();


        $entityManager->persist($user);
        $entityManager->flush();


        return $this->json(['testTitle' => $testTitle]);
    }

}