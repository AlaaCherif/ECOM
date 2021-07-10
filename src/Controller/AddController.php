<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class AddController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $em): Response
    {
        $prod = new Product();
        $form = $this->createForm(AddType::class, $prod);
        $view = $form->createView();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image=$form->get('image')->getData();
            if($image)
            {
                $originalName=pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
                $newName=md5(uniqid()).'.'.$image->guessExtension();
                try
                {
                    $image->move(
                        $this->getParameter('uploads_directory'),
                        $newName
                    );
                }
                catch(FileException $e)
                {   
                    //do nothing
                    echo $e;
                }
                $prod->setImage($newName);
            }
            $prod=$form->getData();
            $em->persist($prod);
            $em->flush();
            $this->addFlash('success', 'Product added');
            return $this->redirectToRoute('home');
        }
        return $this->render('add/index.html.twig', [
            'f' => $view
        ]);
    }
}
