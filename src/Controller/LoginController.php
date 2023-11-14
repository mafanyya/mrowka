<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ItemRepository;
use App\Entity\Item;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// ...

class LoginController extends AbstractController
{

    private ItemRepository $itemRepository;

     public function __construct(ItemRepository $itemRepository) {
            $this->itemRepository = $itemRepository;

       }
    #[Route('/sign_in', name: 'app_login')]
    public function index(): Response
    {
        $items = $this->itemRepository->findAll();


        return $this->render('login.html.twig', [
        'items' => $items

        ]);
    }
    #[Route('/login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->json(['message' => 'Registration successful', 'error'=>$error]);
    }
}