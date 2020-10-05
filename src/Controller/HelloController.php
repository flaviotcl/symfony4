<?php

namespace App\Controller;

use App\Entity\Produto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @return Response
     * 
     * @Route("hello_world")  
     */
    public function world()
    {
        return new Response("<html><body><h1>HELLO WORLD</h1></body></html>");
    }

    /**
     * @return Response
     * 
     * @Route("mostrar-mensagem")  
     */
    public function msg()
    {
        return $this->render("hello/msg.html.twig",
                             ["mensagem"=>"Olá SON"]
                            );
    }

    /**
     * @return Response
     * 
     * @Route("cadastrar-produto")  
     */
    public function produto()
    {
        $em = $this->getDoctrine()->getManager();

        $produto = new Produto();
        $produto->setNome("Smartphone")
                ->setPreco(950.55);

        $em->persist($produto);
        $em->flush();

        return new Response("O Produto".$produto->getId(). " foi criado");
    }

}