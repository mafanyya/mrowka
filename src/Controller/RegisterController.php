<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ItemRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;

// ...

class RegisterController extends AbstractController
{

    private ItemRepository $itemRepository;

     public function __construct(ItemRepository $itemRepository) {
            $this->itemRepository = $itemRepository;

       }
    #[Route('/sign_up')]
    public function index(): Response
    {
        $items = $this->itemRepository->findAll();


        return $this->render('register.html.twig', [
        'items' => $items

        ]);
    }
    #[Route('/register')]
        public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
        {
            $data =json_decode($request->getContent(), true);
            $user = new User();
            $email = $data['email'];
            $plainPassword = $data['password'];
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();
            
            return $this->json(['message' => 'Registration successful']);

        }
}