<?php

namespace App\Controller;

use App\Entity\Word;
use App\Repository\LessonRepository;
use App\Repository\LessonSectionRepository;
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


class WordController extends AbstractController
{


    #[Route('/api/words', name: 'api_words')]
    public function words(WordRepository $wordRepository)
    {
        $words = $wordRepository->findAll();
        $wordsArray = [];

        foreach ($words as $word) {
            $lesson = $word->getLesson();
            $lessonId = $lesson->getId();
            $lessonImg = $lesson->getImg();


            $wordsArray[] = [
                'id' => $word->getId(),
                'name' => $word->getName(),
                'translation' => $word->getTranslation(),
                'lessonId' => $lessonId,
                'lessonImg' => $lessonImg
            ];
        }

        return $this->json(['words' => $wordsArray]);
    }

    #[Route('/api/words-count', name: 'api_words_count')]
    public function wordsCount(WordRepository $wordRepository)
    {
        $words = $wordRepository->findAll();

        $wordsCount = count($words);

        return $this->json([
            'wordsCount' => $wordsCount
        ]);
    }

    #[Route('/api/words-by-section', name: 'api_words_by_section')]
    public function wordsBySection(WordRepository $wordRepository, Request $request, LessonSectionRepository $lessonSectionRepository, LessonRepository $lessonRepository)
    {
        $data = json_decode($request->getContent(), associative: true);
        $sectionId = $data['sectionId'];
        $lessonsBySection = $lessonRepository->findLessonsBySection($sectionId);
        $wordsBySectionArray = [];

        foreach ($lessonsBySection as $lesson) {
            $lessonId = $lesson->getId();
            $lessonImg = $lesson->getImg();
            $wordsBySection = $wordRepository->findWordsByLesson($lessonId);
            foreach ($wordsBySection as $word) {
                $wordsBySectionArray[] = [
                    'id' => $word->getId(),
                    'name' => $word->getName(),
                    'translation' => $word->getTranslation(),
                    'lessonId' => $lessonId,
                    'lessonImg' => $lessonImg
                ];
            }
        }
        return $this->json(['words' => $wordsBySectionArray]);
    }

    #[Route('/api/words-by-lesson', name: 'api_words_by_lesson')]
    public function wordsByLesson(WordRepository $wordRepository, Request $request, LessonSectionRepository $lessonSectionRepository, LessonRepository $lessonRepository)
    {
        $data = json_decode($request->getContent(), associative: true);
        $lessonId = $data['lessonId'];
        $lesson = $lessonRepository->find($lessonId);
        $wordsByLesson = $wordRepository->findWordsByLesson($lessonId);
        $lessonImg = $lesson->getImg();
        $wordsByLessonArray = [];
        foreach ($wordsByLesson as $word) {
            $wordsByLessonArray[] = [
                'id' => $word->getId(),
                'name' => $word->getName(),
                'translation' => $word->getTranslation(),
                'lessonId' => $lessonId,
                'lessonImg' => $lessonImg
            ];
        }
        return $this->json(['words' => $wordsByLessonArray]);
    }

    #[Route('/api/add-word', name: 'api_add_word')]
    public function addWord(WordRepository $wordRepository, Request $request, LessonRepository $lessonRepository, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $name = $data['name'];
        $translation = $data['translation'];
        $lessonId = $data['lessonId'];
        $lesson = $lessonRepository->find($lessonId);


        $word = new Word();
        $word->setName($name);
        $word->setTranslation($translation);

        $dictionary = $lesson->getDictionary();
        $dictionary->add($word);
        $word->setLesson($lesson);

        $entityManager->persist($word);
        $entityManager->flush();

        return $this->json(['message' => "Word $name successfully added."]);
    }

    #[Route('/api/remove-word', name: 'api_remove_word')]
    public function removeWord(WordRepository $wordRepository, Request $request)
    {
        $data = json_decode($request->getContent(), associative: true);
        $wordId = $data['id'];

        $word = $wordRepository->find($wordId);
        $wordName = $word->getName();

        $wordRepository->remove($word);

        return $this->json(['message' => "Word $wordName successfully deleted."]);
    }


}