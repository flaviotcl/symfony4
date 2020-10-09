<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Form\ProdutoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProdutoController extends AbstractController
{
    /**
     * @Route("/produto", name="produto")
     */
    public function index()
    {
            $em = $this->getDoctrine()->getManager();

            $produtos  =  $em->getRepository(Produto::class)->findAll();

            return $this->render("produto/index.html.twig",[
                'produtos' => $produtos
    ]);
    }

    /**
     * @param Request $request
     * @Route("/produto/cadastrar", name="cadastrar_produto")
     */
    public function create( Request $request)
    {
        $produto = new Produto();

        $form = $this->createForm(ProdutoType::class, $produto);

        return $this->render("produto/create.html.twig",
            ['form' => $form->createView()]
            );
    }
}
