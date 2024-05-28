<?php

namespace App\Controller;

use App\Repository\AchievementRepository;
use App\Repository\LessonRepository;
use App\Repository\LessonSectionRepository;
use App\Repository\TestRepository;
use App\Repository\UserRepository;
use App\Repository\WordRepository;
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
    public function getCredential(UserRepository $userRepository, WordRepository $wordRepository, LessonRepository $lessonRepository,
                                  LessonSectionRepository $lessonSectionRepository, AchievementRepository $achievementRepository,
                                  TestRepository $testRepository):Response
    {
        $userValue = $this->getUser();
        $userIdentifier = $userValue->getUserIdentifier();
        $user = $userRepository->findOneByEmail($userIdentifier);
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

    #[Route('/api/logout', name: 'api_logout')]
    public function logout(Request $request, RefreshToken $refreshToken):Response
    {
        return $this->json(['status' => 'OK']);

    }

}