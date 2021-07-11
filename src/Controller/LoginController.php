<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use App\Entity\Product;

class LoginController extends AbstractController
{
    private $session;
    #[Route('/', name: 'home')]
    public function home(EntityManagerInterface $em,Request $request): Response
    {
        $form=$this->createFormBuilder(null)
            ->add('Search',TypeTextType::class,[
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
    public function __construct()
    {
        $this->session =new Session();
    }
    #[Route('/signup', name: 'singup')]
    public function index(Request $request,EntityManagerInterface $em): Response
    {
        $user=new User();
        $form=$this->createForm(SignUpType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $user=$form->getData();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Account created');
            $this->session->start();
            $this->session->set('user',$user);
            return $this->render('base.html.twig',[
                
            ]);
        }
        $view=$form->createView();
        return $this->render('login/index.html.twig', [
            'form' =>$view,
        ]);
    }
    #[Route('/first', name:'first')]
    public function  first(Request $request)
    {
        if($this->session->get('id') !== -1 && $this->session->get('id') !==null )
        {
            $this->redirectToRoute('home');
        }
        else
        {
            return $this->render('login/index.html.twig',[
            'username'=>$this->session->get('id')
        ]);
    }
    }
}
