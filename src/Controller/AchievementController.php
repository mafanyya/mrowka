<?php

namespace App\Controller;

use App\Entity\Achievement;
use App\Entity\Answer;
use App\Entity\Lesson;
use App\Entity\LessonSection;
use App\Entity\Question;
use App\Entity\Test;
use App\Repository\AchievementRepository;
use App\Repository\LessonRepository;
use App\Repository\LessonSectionRepository;
use App\Repository\TestRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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


class AchievementController extends AbstractController
{
    #[Route('/api/achievements', name: 'api_achievements')]
    public function achievements(AchievementRepository $achievementRepository)
    {
        $achievements = $achievementRepository->findAll();
        $achievementsArray = [];

        foreach ($achievements as $achievement) {

            $achievementsArray[] = [
                'id' => $achievement->getId(),
                'uniqid' => $achievement->getUniqid(),
                'title' => $achievement->getTitle(),
                'img' => $achievement->getImg(),
                'lessonId' => $achievement->getLesson()->getId(),
            ];
        }
        return $this->json(['achievements' => $achievementsArray]);
    }

    #[Route('/api/achievements-count', name: 'api_achievements_count')]
    public function achievementsCount(AchievementRepository $achievementRepository)
    {
        $achievements = $achievementRepository->findAll();

        $achievementsCount = count($achievements);

        return $this->json([
            'achievementsCount' => $achievementsCount
        ]);
    }


    #[Route('/api/achievement-edit', name: 'api_achievement_edit')]
    public function edit(AchievementRepository $achievementRepository, LessonRepository $lessonRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $title = $data['title'];
        $img = $data['img'];
        $lessonId = $data['lessonId'];

        $lesson = $lessonRepository->find($lessonId);

        $achievement = $achievementRepository->find($id);
        $achievement->setTitle($title);
        $achievement->setImg($img);
        $achievement->setLesson($lesson);
        $entityManager->persist($achievement);
        $entityManager->flush();


        return $this->json(['message' => 'Achievement successfully edited']);
    }

    #[Route('/api/remove-achievement', name: 'api_remove_achievement')]
    public function removeAchievement(AchievementRepository $achievementRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $achievementId = $data['id'];

        $achievement = $achievementRepository->find($achievementId);


        $achievementRepository->remove($achievement);

        return $this->json(['message' => "Achivement $achievementId successfully deleted."]);
    }

    #[Route('/api/add-achievement', name: 'api_achievement_add')]
    public function add(AchievementRepository $achievementRepository, LessonRepository $lessonRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $title = $data['title'];
        $img = $data['img'];
        $lessonId = $data['lessonId'];
        $uniqId = $this->uniqidGen();

        $lesson = $lessonRepository->find($lessonId);

        $achievement = new Achievement();
        $achievement->setUniqid($uniqId);
        $achievement->setTitle($title);
        $achievement->setImg($img);
        $achievement->setLesson($lesson);

        $entityManager->persist($achievement);
        $entityManager->flush();

        return $this->json(['message' => 'Achievement successfully edited']);
    }

    #[Route('/api/upload-img-achievement', name: 'api_upload_img_achievement')]
    public function uploadImg(Request $request)
    {
        $img = $request->files->get('image');

        if (!$img) {
            return $this->json([
                'error' => 'No img data',
            ]);
        }
        $img = $request->files->get('image');
        $imgName = 'img_' . $this->uniqidGen() . '.' . $img->guessExtension();
        try {
            $img->move(
                $this->getParameter('uploads_directory_achievements'),
                $imgName
            );
        } catch (FileException $e) {
            return $this->json([
                'error' => 'Upload img error',
                'img' => $img
            ]);
        }
        return $this->json([
            'data' => 'Img successfully uploaded',
            'imgName' => $imgName
        ]);

    }

    public function uniqidGen($lenght = 13)
    {
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