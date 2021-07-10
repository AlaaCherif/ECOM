<?php
namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class ProductController extends AbstractController
{
    
    #[Route('/all', name: 'allProducts')]
    public function getProds(Request $request):Response
    {
        $form=$this->createFormBuilder(null)
            ->add('Search',TextType::class,[
                'attr'=>[
                    'class'=>'form-control me-sm-2',
                    'placeholder'=>'Search Procuts'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-secondary my-2 my-sm-0',
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        $repo=$this->getDoctrine()->getRepository(Product::class);
        $products=$repo->findAll();
        if ($form->isSubmitted() && $form->isValid())
        {
            $keyword=$form->getData();
            $products=$repo->findBy(['name'=>$keyword]);
            return $this->render('home.html.twig',[
                'prods'=>$products,
                'form'=>$form->createView(),
                'key'=>$keyword
            ]);
        }
        
        return $this->render('all.html.twig',[
            'prods'=>$products,
            'form'=>$form->createView()
        ]);
    }


    #[Route('/product/{id<\d+>}', name: 'product')]
    public function getProd($id): Response
    {
        $repo=$this->getDoctrine()->getRepository(Product::class);
        $product=$repo->find($id);
        return $this->render('product.html.twig', [
            'product' => $product,
        ]);
    }
}

