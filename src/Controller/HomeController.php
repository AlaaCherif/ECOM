<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $em,Request $request): Response
    {
        $form=$this->createFormBuilder(null)
            ->add('Search',TextType::class,[
                'attr'=>[
                    'class'=>'form-control me-sm-2',
                    'placeholder'=>'Search Procuts',
                    'type'=>'text'
                ],
                'label'=>false
            ])
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-secondary my-2 my-sm-0',
                    'float'=>'right'
                    
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        $repo=$this->getDoctrine()->getRepository(Product::class);
        if ($form->isSubmitted() && $form->isValid())
        {
            $keyword=$form->getData();
            $products=$repo->findBy(['name'=>$keyword]);
            return $this->render('home.html.twig',[
                'prods'=>$products,
                'form'=>$form->createView()
            ]);
        }

        $products=$repo->findBy(['recommended'=>'true']);
        return $this->render('home.html.twig',[
            'prods'=>$products,
            'form'=>$form->createView()
        ]);
    }
}
