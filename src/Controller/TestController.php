<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\LessonSection;
use App\Repository\AnswerRepository;
use App\Repository\LessonRepository;
use App\Repository\LessonSectionRepository;
use App\Repository\QuestionRepository;
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


class TestController extends AbstractController
{
    #[Route('/api/tests', name: 'api_tests')]
    public function tests(TestRepository $testRepository, QuestionRepository $questionRepository, AnswerRepository $answerRepository)
    {
        $tests = $testRepository->findAll();
        $questions = $questionRepository->findAll();
        $answers = $answerRepository->findAll();
        $testsArray = [];
        $questionsArray = [];
        $answersArray = [];

        foreach ($tests as $test) {
            $lessonTest = $test->getLesson();
            $lessonTestId = $lessonTest->getId();
            $testsArray[] = [
                'id' => $test->getId(),
                'uniqId' => $test->getUniqid(),
                'title' => $test->getTitle(),
                'lessonId' => $lessonTestId
            ];
        }
        foreach ($questions as $question) {
            $questionTest = $question->getTest();
            $questionTestId = $questionTest->getId();
            $questionsArray[] = [
                'id' => $question->getId(),
                'title' => $question->getTitle(),
                'testId' => $questionTestId
            ];
        }
        foreach ($answers as $answer) {
            $answerQuestion = $answer->getQuestion();
            $answerQuestionId = $answerQuestion->getId();
            $answersArray[] = [
                'id' => $answer->getId(),
                'title' => $answer->getTitle(),
                'questionId' => $answerQuestionId
            ];
        }
        return $this->json([
            'tests' => $testsArray,
            'questions' => $questionsArray,
            'answers' => $answersArray
        ]);
    }

    #[Route('/api/tests-count', name: 'api_tests_count')]
    public function testsCount(TestRepository $testRepository, QuestionRepository $questionRepository, AnswerRepository $answerRepository)
    {
        $tests = $testRepository->findAll();

        $testsCount = count($tests);

        return $this->json([
            'testsCount' => $testsCount
        ]);
    }

    #[Route('/api/test-by-id', name: 'api_test_by_id')]
    public function testById(TestRepository $testRepository, QuestionRepository $questionRepository, AnswerRepository $answerRepository, Request $request)
    {
        $data = json_decode($request->getContent(), associative: true);
        $testId = $data['id'];
        $test = $testRepository->find($testId);
        $lessonTestId = $test->getLesson()->getId();
        $questions = $questionRepository->findQuestionsByTestId($testId);
        $questionsArray = [];
        $answersArray = [];
        $questionsIdArray = [];

        $answers = $answerRepository->findAll();
        foreach ($answers as $answer) {
            $questionId = $answer->getQuestion()->getId();
            $answersArray[] = [
                'id' => $answer->getId(),
                'title' => $answer->getTitle(),
                'isTrue' => $answer->isIsTrue(),
                'number' => $answer->getNumber(),
                'questionId' => $questionId
            ];
        }
        foreach ($questions as $question) {
            $questionsArray[] = [
                'id' => $question->getId(),
                'title' => $question->getTitle(),
                'img' => $question->getImg(),
                'number' => $question->getNumber()
            ];
        }

        $testArray = [
            'id' => $test->getId(),
            'uniqId' => $test->getUniqid(),
            'title' => $test->getTitle(),
            'lessonId' => $lessonTestId
        ];

        return $this->json([
            'test' => $testArray,
            'questions' => $questionsArray,
            'answers' => $answersArray
        ]);
    }

    #[Route('/api/question-by-id', name: 'api_question_by_id')]
    public function questionById(QuestionRepository $questionRepository, Request $request)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $question = $questionRepository->find($id);
        $testQuestionId = $question->getTest()->getId();

        $questionArray = [
            'id' => $question->getId(),
            'title' => $question->getTitle(),
            'testId' => $testQuestionId
        ];

        return $this->json([
            'question' => $questionArray]);
    }

    #[Route('/api/answer-by-id', name: 'api_answer_by_id')]
    public function answerById(AnswerRepository $answerRepository, Request $request)
    {
        $data = json_decode($request->getContent(), associative: true);
        $id = $data['id'];
        $answer = $answerRepository->find($id);
        $questionAnswerId = $answer->getQuestion()->getId();

        $answerArray = [
            'id' => $answer->getId(),
            'title' => $answer->getTitle(),
            'questionId' => $questionAnswerId
        ];

        return $this->json([
            'answer' => $answerArray]);
    }

    #[Route('/api/edit-test', name: 'api_edit_test')]
    public function editTest(AnswerRepository $answerRepository, TestRepository $testRepository, QuestionRepository $questionRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), associative: true);
        $testId = $data['testId'];
        $testTitle = $data['testTitle'];

        $question1Id = $data['question1Id'];
        $question1Title = $data['question1Title'];

        $question2Id = $data['question2Id'];
        $question2Title = $data['question2Title'];

        $question3Id = $data['question3Id'];
        $question3Title = $data['question3Title'];

        $question4Id = $data['question4Id'];
        $question4Title = $data['question4Title'];

        $question5Id = $data['question5Id'];
        $question5Title = $data['question5Title'];

        $answerId_1_1 = $data['answerId_1_1'];
        $answerId_1_2 = $data['answerId_1_2'];
        $answerId_1_3 = $data['answerId_1_3'];

        $answerIsTrue_1_1 = filter_var($data['answerIsTrue_1_1'], FILTER_VALIDATE_BOOLEAN);
        $answerIsTrue_1_2 = filter_var($data['answerIsTrue_1_2'], FILTER_VALIDATE_BOOLEAN);
        $answerIsTrue_1_3 = filter_var($data['answerIsTrue_1_3'], FILTER_VALIDATE_BOOLEAN);

        $answerTitle_1_1 = $data['answerTitle_1_1'];
        $answerTitle_1_2 = $data['answerTitle_1_2'];
        $answerTitle_1_3 = $data['answerTitle_1_3'];

        $answerId_2_1 = $data['answerId_2_1'];
        $answerId_2_2 = $data['answerId_2_2'];
        $answerId_2_3 = $data['answerId_2_3'];

        $answerIsTrue_2_1 = filter_var($data['answerIsTrue_2_1'], FILTER_VALIDATE_BOOLEAN);
        $answerIsTrue_2_2 = filter_var($data['answerIsTrue_2_2'], FILTER_VALIDATE_BOOLEAN);
        $answerIsTrue_2_3 = filter_var($data['answerIsTrue_2_3'], FILTER_VALIDATE_BOOLEAN);

        $answerTitle_2_1 = $data['answerTitle_2_1'];
        $answerTitle_2_2 = $data['answerTitle_2_2'];
        $answerTitle_2_3 = $data['answerTitle_2_3'];

        $answerId_3_1 = $data['answerId_3_1'];
        $answerId_3_2 = $data['answerId_3_2'];
        $answerId_3_3 = $data['answerId_3_3'];

        $answerIsTrue_3_1 = filter_var($data['answerIsTrue_3_1'], FILTER_VALIDATE_BOOLEAN);
        $answerIsTrue_3_2 = filter_var($data['answerIsTrue_3_2'], FILTER_VALIDATE_BOOLEAN);
        $answerIsTrue_3_3 = filter_var($data['answerIsTrue_3_3'], FILTER_VALIDATE_BOOLEAN);

        $answerTitle_3_1 = $data['answerTitle_3_1'];
        $answerTitle_3_2 = $data['answerTitle_3_2'];
        $answerTitle_3_3 = $data['answerTitle_3_3'];

        $answerId_4_1 = $data['answerId_4_1'];
        $answerId_4_2 = $data['answerId_4_2'];
        $answerId_4_3 = $data['answerId_4_3'];

        $answerIsTrue_4_1 = filter_var($data['answerIsTrue_4_1'], FILTER_VALIDATE_BOOLEAN);
        $answerIsTrue_4_2 = filter_var($data['answerIsTrue_4_2'], FILTER_VALIDATE_BOOLEAN);
        $answerIsTrue_4_3 = filter_var($data['answerIsTrue_4_3'], FILTER_VALIDATE_BOOLEAN);

        $answerTitle_4_1 = $data['answerTitle_4_1'];
        $answerTitle_4_2 = $data['answerTitle_4_2'];
        $answerTitle_4_3 = $data['answerTitle_4_3'];

        $answerId_5_1 = $data['answerId_5_1'];
        $answerId_5_2 = $data['answerId_5_2'];
        $answerId_5_3 = $data['answerId_5_3'];

        $answerIsTrue_5_1 = filter_var($data['answerIsTrue_5_1'], FILTER_VALIDATE_BOOLEAN);
        $answerIsTrue_5_2 = filter_var($data['answerIsTrue_5_2'], FILTER_VALIDATE_BOOLEAN);
        $answerIsTrue_5_3 = filter_var($data['answerIsTrue_5_3'], FILTER_VALIDATE_BOOLEAN);

        $answerTitle_5_1 = $data['answerTitle_5_1'];
        $answerTitle_5_2 = $data['answerTitle_5_2'];
        $answerTitle_5_3 = $data['answerTitle_5_3'];

        $test = $testRepository->find($testId);
        $test->setTitle($testTitle);

        $question1 = $questionRepository->find($question1Id);
        $question1->setTitle($question1Title);

        $question2 = $questionRepository->find($question2Id);
        $question2->setTitle($question2Title);

        $question3 = $questionRepository->find($question3Id);
        $question3->setTitle($question3Title);

        $question4 = $questionRepository->find($question4Id);
        $question4->setTitle($question4Title);

        $question5 = $questionRepository->find($question5Id);
        $question5->setTitle($question5Title);

        $answer_1_1 = $answerRepository->find($answerId_1_1);
        $answer_1_1->setTitle($answerTitle_1_1);
        $answer_1_1->setIsTrue($answerIsTrue_1_1);


        $answer_1_2 = $answerRepository->find($answerId_1_2);
        $answer_1_2->setTitle($answerTitle_1_2);
        $answer_1_2->setIsTrue($answerIsTrue_1_2);

        $answer_1_3 = $answerRepository->find($answerId_1_3);
        $answer_1_3->setTitle($answerTitle_1_3);
        $answer_1_3->setIsTrue($answerIsTrue_1_3);


        $answer_2_1 = $answerRepository->find($answerId_2_1);
        $answer_2_1->setTitle($answerTitle_2_1);
        $answer_2_1->setIsTrue($answerIsTrue_2_1);

        $answer_2_2 = $answerRepository->find($answerId_2_2);
        $answer_2_2->setTitle($answerTitle_2_2);
        $answer_2_2->setIsTrue($answerIsTrue_2_2);

        $answer_2_3 = $answerRepository->find($answerId_2_3);
        $answer_2_3->setTitle($answerTitle_2_3);
        $answer_2_3->setIsTrue($answerIsTrue_2_3);


        $answer_3_1 = $answerRepository->find($answerId_3_1);
        $answer_3_1->setTitle($answerTitle_3_1);
        $answer_3_1->setIsTrue($answerIsTrue_3_1);

        $answer_3_2 = $answerRepository->find($answerId_3_2);
        $answer_3_2->setTitle($answerTitle_3_2);
        $answer_3_2->setIsTrue($answerIsTrue_3_2);

        $answer_3_3 = $answerRepository->find($answerId_3_3);
        $answer_3_3->setTitle($answerTitle_3_3);
        $answer_3_3->setIsTrue($answerIsTrue_3_3);


        $answer_4_1 = $answerRepository->find($answerId_4_1);
        $answer_4_1->setTitle($answerTitle_4_1);
        $answer_4_1->setIsTrue($answerIsTrue_4_1);

        $answer_4_2 = $answerRepository->find($answerId_4_2);
        $answer_4_2->setTitle($answerTitle_4_2);
        $answer_4_2->setIsTrue($answerIsTrue_4_2);

        $answer_4_3 = $answerRepository->find($answerId_4_3);
        $answer_4_3->setTitle($answerTitle_4_3);
        $answer_4_3->setIsTrue($answerIsTrue_4_3);


        $answer_5_1 = $answerRepository->find($answerId_5_1);
        $answer_5_1->setTitle($answerTitle_5_1);
        $answer_5_1->setIsTrue($answerIsTrue_5_1);

        $answer_5_2 = $answerRepository->find($answerId_5_2);
        $answer_5_2->setTitle($answerTitle_5_2);
        $answer_5_2->setIsTrue($answerIsTrue_5_2);

        $answer_5_3 = $answerRepository->find($answerId_5_3);
        $answer_5_3->setTitle($answerTitle_5_3);
        $answer_5_3->setIsTrue($answerIsTrue_5_3);

        $entityManager->persist($test);

        $entityManager->persist($question1);
        $entityManager->persist($question2);
        $entityManager->persist($question3);
        $entityManager->persist($question4);
        $entityManager->persist($question5);

        $entityManager->persist($answer_1_1);
        $entityManager->persist($answer_1_2);
        $entityManager->persist($answer_1_3);

        $entityManager->persist($answer_2_1);
        $entityManager->persist($answer_2_2);
        $entityManager->persist($answer_2_3);

        $entityManager->persist($answer_3_1);
        $entityManager->persist($answer_3_2);
        $entityManager->persist($answer_3_3);

        $entityManager->persist($answer_4_1);
        $entityManager->persist($answer_4_2);
        $entityManager->persist($answer_4_3);

        $entityManager->persist($answer_5_1);
        $entityManager->persist($answer_5_2);
        $entityManager->persist($answer_5_3);


        $entityManager->flush();

        return $this->json([
            'message' => 'Test edited successfully']);
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
