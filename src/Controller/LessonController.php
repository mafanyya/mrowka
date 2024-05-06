<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use App\Repository\LessonSectionRepository;
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


class LessonController extends AbstractController
{


    #[Route('/api/lessons', name: 'api_lessons')]
    public function lessons(LessonRepository $lessonRepository)
    {
        $lessons = $lessonRepository->findAll();
        $lessonsArray = [];


        foreach ($lessons as $lesson) {
            $lessonSection = $lesson->getLessonSection();
            $lessonSectionId = $lessonSection->getId();
            $lessonsArray[] = [
                'id' => $lesson->getId(),
                'uniqid' => $lesson->getUniqid(),
                'title' => $lesson->getTitle(),
                'description' => $lesson->getDescription(),
                'number' => $lesson->getNumber(),
                'lessonSection' => $lessonSectionId,
                'img' => $lesson->getImg()
            ];
        }

        return $this->json(['lessons' => $lessonsArray]);
    }

    #[Route('/api/lesson-sections', name: 'api_lesson_sections')]
    public function lessonSections(LessonSectionRepository $lessonSectionRepository, LessonRepository $lessonRepository)
    {
        $lessonSections = $lessonSectionRepository->findAll();
        $sectionsArray = [];
        $lessonsArray = [];

        foreach ($lessonSections as $section) {
            $sectionId = $section->getId();
            $lessons = $lessonRepository->findLessonsBySection($sectionId);
            foreach ($lessons as $lesson) {
                $lessonsArray[] = [
                    'id' => $lesson->getId(),
                    'uniqId' => $lesson->getUniqid(),
                    'title' => $lesson->getTitle(),
                    'description' => $lesson->getDescription(),
                    'number' => $lesson->getNumber(),
                    'img' => $lesson->getImg(),
                    'sectionId' => $sectionId
                ];
            }
            $sectionsArray[] = [
                'id' => $sectionId,
                'title' => $section->getTitle(),
                'description' => $section->getDescription(),
                'img' => $section->getImg(),
                'difficulty' => $section->getDifficulty()
            ];

        }
        return $this->json(['sections' => $sectionsArray, 'lessons' => $lessonsArray]);
    }

    #[Route('/api/lessons-by-section', name: 'api_lessons_by_section')]
    public function lessonBySection(LessonRepository $lessonRepository, Request $request)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $lessonsBySection = $lessonRepository->findLessonsBySection($id);
        $lessonsCount = count($lessonsBySection);
        if ($lessonsBySection == null) {
            $lessonsCount = 0;
        }
        $lessonsArray = [];
        foreach ($lessonsBySection as $lesson) {
            $lessonSection = $lesson->getLessonSection();
            $lessonSectionId = $lessonSection->getId();
            $lessonsArray[] = [
                'id' => $lesson->getId(),
                'uniqId' => $lesson->getUniqid(),
                'title' => $lesson->getTitle(),
                'description' => $lesson->getDescription(),
                'number' => $lesson->getNumber(),
                'img' => $lesson->getImg(),
                'lessonSectionId' => $lessonSectionId
            ];
        }

        return $this->json([
            'lessonsCount' => $lessonsCount,
            'lessons' => $lessonsArray]);
    }

    #[Route('/api/add-lesson', name: 'api_add_lesson')]
    public function addLesson(LessonRepository $lessonRepository, Request $request, LessonSectionRepository $lessonSectionRepository, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $title = $data['title'];
        $description = $data['description'];
        $sectionId = $data['sectionId'];
        $section = $lessonSectionRepository->find($sectionId);
        $sectionImg = $section->getImg();
        $uniqId = $this->uniqidGen();

        $lesson =  new Lesson();
        $lesson->setTitle($title);
        $lesson->setDescription($description);
        $lesson->setUniqid($uniqId);
        $lesson->setImg($sectionImg);
        $lesson->setLessonSection($section);

        $entityManager->persist($lesson);
        $entityManager->flush();

        return $this->json(['message' => "Lesson $title successfully added."]);
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