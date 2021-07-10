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
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends AbstractController
{
    private $session;
    public function __construct()
    {
        $this->session =new Session();
    }
    #[Route('/login', name: 'login')]
    public function index(HttpFoundationRequest $request,EntityManagerInterface $em): Response
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
            return $this->redirectToRoute('home');
        }
        $view=$form->createView();
        return $this->render('login/index.html.twig', [
            'form' =>$view,
        ]);
    }
}
