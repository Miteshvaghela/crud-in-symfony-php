<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Product;
use App\Form\ProductType;



#[Route('/product', name: 'product.')]
class ProductController extends AbstractController{

    #[Route('/', name : 'list')]
    public function index(EntityManagerInterface $entityManager){
        $title = "Featured Products";
        $products = $entityManager->getRepository(Product::class)->findAll();
        //dump($products); die;
        return $this->render('/product/index.html.twig', [
            'title' => $title,
            'products' => $products
        ]);
    }

    #[Route('/create', name : 'create')]
    public function create(EntityManagerInterface $entityManager, Request $request){
        $title = 'Create new product';
        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);
        $form->add('Create', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-3'
            ]
            ]);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Product created.');
            return $this->redirect($this->generateUrl('product.list'));
        }

        return $this->render('/product/create.html.twig', [
            'title' => $title,
            'form' => $form
        ]);
    }

    #[Route('/delete', name : 'delete')]
    public function delete(EntityManagerInterface $entityManager, Request $request){
        $id = (int) $request->get('id');

        $product = $entityManager->getRepository(Product::class)->findOneById($id);
        if($product){
            $entityManager->remove($product);
            $entityManager->flush();
            $this->addFlash('success', 'Product has been deleted.');
        }
        return $this->redirect($this->generateUrl('product.list'));
    }

    #[Route('/update', name : 'update')]
    public function update(Request $request){
        $id = (int) $request->get('id');

        return new Response("<h3>Product update id : {$id}</h3>");
    }
}