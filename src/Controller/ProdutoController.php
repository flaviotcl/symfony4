<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProdutoController extends AbstractController
{
    /**
     * @Route("/produto", name="produto")
     */
    public function index()
    {
        return $this->render('produto/index.html.twig', [
            'controller_name' => 'ProdutoController',
        ]);
    }
}
