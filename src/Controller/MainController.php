<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;


class MainController extends AbstractController{

    #[Route('/', name : 'home')]
    public function index(EntityManagerInterface $entityManager){
        $title = "Home page";
        return $this->render('/main/index.html.twig', [
            'title' => $title
        ]);
    }

    #[Route('/about', name : 'about')]
    public function about(){
        $title = "About us";

        return $this->render('/main/about.html.twig', [
            'title' => $title
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(){
        $title = "Contact us";

        return $this->render('/main/contact.html.twig', [
            'title' => $title
        ]);
    }
}