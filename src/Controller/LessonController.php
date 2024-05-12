<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\LessonSection;
use App\Repository\LessonRepository;
use App\Repository\LessonSectionRepository;
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
    #[Route('/api/lesson-by-id', name: 'api_lesson_by_id')]
    public function lessonById(LessonRepository $lessonRepository, Request $request)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $lesson = $lessonRepository->find($id);
        $lessonArray = [];
        $lessonSection = $lesson->getLessonSection();
        $lessonSectionId = $lessonSection->getId();
        $lessonArray = [
          'id' => $lesson->getId(),
          'title' => $lesson->getTitle(),
          'uniqId' => $lesson->getUniqid(),
          'img' => $lesson->getImg(),
          'description' => $lesson->getDescription(),
          'lessonSection' => $lessonSectionId
        ];
        return $this->json([
            'lesson' => $lessonArray]);
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
                'difficulty' => $section->getDifficulty(),
                'uniqid' => $section->getUniqid()
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
    #[Route('/api/section-by-uniqid', name: 'api_section_by_uniqid')]
    public function sectionByUniqId(LessonRepository $lessonRepository, LessonSectionRepository $lessonSectionRepository, Request $request)
    {
        $data = json_decode($request->getContent(), associative: true);
        $uniqid = $data['uniqid'];

        $section = $lessonSectionRepository->findLessonSectionByUniqId($uniqid);
        $sectionArray = [];
        $sectionArray[] = [
          'id' => $section->getId(),
          'uniqId' => $section->getUniqid(),
          'title' => $section->getTitle(),
          'description' => $section->getDescription(),
          'difficulty' => $section->getDifficulty(),
          'img' => $section->getImg(),
        ];
        return $this->json([
            'section' => $sectionArray]);
    }


    #[Route('/api/add-lesson', name: 'api_add_lesson')]
    public function addLesson(Request $request, LessonSectionRepository $lessonSectionRepository, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $title = $data['title'];
        $description = $data['description'];
        $sectionId = $data['sectionId'];
        $section = $lessonSectionRepository->find($sectionId);
        $sectionImg = $section->getImg();
        $uniqId = $this->uniqidGen();

        $lesson = new Lesson();
        $lesson->setTitle($title);
        $lesson->setDescription($description);
        $lesson->setUniqid($uniqId);
        $lesson->setImg($sectionImg);
        $lesson->setLessonSection($section);

        $entityManager->persist($lesson);
        $entityManager->flush();

        return $this->json(['message' => "Lesson $title successfully added."]);
    }

    #[Route('/api/edit-lesson', name: 'api_edit_lesson')]
    public function editLesson(Request $request, LessonSectionRepository $lessonSectionRepository, LessonRepository $lessonRepository, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $title = $data['title'];
        $description = $data['description'];
        $sectionId = $data['sectionId'];

        $lesson = $lessonRepository->find($id);
        $section = $lessonSectionRepository->find($sectionId);
        $sectionImg = $section->getImg();
        $uniqId = $this->uniqidGen();

        $lesson->setTitle($title);
        $lesson->setDescription($description);
        $lesson->setUniqid($uniqId);
        $lesson->setLessonSection($section);
        $lesson->setImg($sectionImg);

        $entityManager->persist($lesson);
        $entityManager->flush();

        return $this->json(['message' => "Lesson $title successfully edited."]);
    }

    #[Route('/api/add-lesson-section', name: 'api_add_lesson_section')]
    public function addLessonSection(Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $title = $data['title'];
        $description = $data['description'];
        $difficulty = $data['difficulty'];
        $img = $data['img'];


        $section = new LessonSection();
        $section->setTitle($title);
        $section->setDescription($description);
        $section->setDifficulty($difficulty);
        $section->setImg($img);
        $section->setUniqid($this->uniqidGen());


        $entityManager->persist($section);
        $entityManager->flush();

        return $this->json(['message' => "Section $title successfully added."]);
    }
    #[Route('/api/edit-lesson-section', name: 'api_edit_lesson_section')]
    public function editLessonSection(LessonSectionRepository $lessonSectionRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $title = $data['title'];
        $description = $data['description'];
        $difficulty = $data['difficulty'];
        $img = $data['img'];


        $section = $lessonSectionRepository->find($id);
        $section->setTitle($title);
        $section->setDescription($description);
        $section->setDifficulty($difficulty);
        $section->setImg($img);

        $entityManager->persist($section);
        $entityManager->flush();

        return $this->json(['message' => "Section $title successfully edited."]);
    }
    #[Route('/api/remove-lesson', name: 'api_remove_lesson')]
    public function removeLesson(LessonRepository $lessonRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $lessonId = $data['id'];

        $lesson = $lessonRepository->find($lessonId);
        $lessonUniqId = $lesson->getUniqid();
        $lessonRepository->remove($lesson);

        return $this->json(['message' => "Lesson $lessonUniqId successfully deleted."]);
    }
    #[Route('/api/remove-lesson-section', name: 'api_remove_lesson_section')]
    public function removeLessonSection(LessonSectionRepository $lessonSectionRepository, LessonRepository $lessonRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $sectionUniqId = $data['uniqId'];


        $lessonSection = $lessonSectionRepository->findLessonSectionByUniqId($sectionUniqId);
        $lessonSectionId = $lessonSection->getId();
        $lessons = $lessonRepository->findLessonsBySection($lessonSectionId);
        foreach($lessons as $lesson){
            $lessonRepository->remove($lesson);
        }

        $lessonSectionRepository->remove($lessonSection);

        return $this->json(['message' => "Lesson $sectionUniqId successfully deleted."]);
    }

    #[Route('/api/upload-img', name: 'api_upload_img')]
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
                $this->getParameter('uploads_directory'),
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