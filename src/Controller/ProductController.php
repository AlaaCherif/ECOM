<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/{id}', name: 'product')]
    public function getProd($id): Response
    {
        $repo=$this->getDoctrine()->getRepository(Product::class);
        $product=$repo->find($id);
        return $this->render('product.html.twig', [
            'product' => $product,
        ]);
    }
}
