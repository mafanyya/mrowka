<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ItemRepository;
use App\Entity\Item;

// ...

class HomeController extends AbstractController
{

    private ItemRepository $itemRepository;

     public function __construct(ItemRepository $itemRepository) {
            $this->itemRepository = $itemRepository;

       }
    #[Route('/')]
    public function index(): Response
    {
        $items = $this->itemRepository->findAll();
        

        return $this->render('base.html.twig', [
        'items' => $items
            
        ]);
    }
}
