<?php

namespace App\Controller;

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

        return $this->json(['lessons' => $lessons]);
    }
    #[Route('/api/lesson-sections', name: 'api_lesson_sections')]
    public function lessonSections(LessonSectionRepository $lessonSectionRepository)
    {
        $lessonSections = $lessonSectionRepository->findAll();

        return $this->json(['lessonSections' => $lessonSections]);
    }
    #[Route('/api/lessons-by-section', name: 'api_lessons_by_section')]
    public function lessonBySection(LessonRepository $lessonRepository, Request $request)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $lessonsBySection = $lessonRepository->findLessonsBySection($id);
        $lessonsCount = count($lessonsBySection);
        if($lessonsBySection == null){
            $lessonsCount = 0;
        }

        return $this->json(['lessons' => $lessonsBySection,
            'lessonsCount' => $lessonsCount]);
    }



}