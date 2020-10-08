<?php

namespace App\Controller;

use App\Entity\Produto;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

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
                             ["mensagem"=>"Olá School of Net"]
                            );
    }

    /**
     * @return Response
     * 
     * @Route("cadastrar-produto")  
     */
    public function produto()
    {# code...
        $produto->setNome("Smartphone")
                ->setPreco(950.55);

        $em->persist($produto);
        $em->flush();

        return new Response("O Produto".$produto->getId(). " foi criado");
    }
    /**
     * @return Response
     * 
     * @Route("formulario")  
     */
    public function formulario(Request $request)
    {
        $produto = new Produto();

        $form = $this->createFormBuilder($produto)
                ->add('nome', TextType::class)
                ->add('preco', NumberType::class)
                ->add('enviar', SubmitType::class, ['label' => "Salvar"])
                ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            return new Response("Formulário etá OK !");
        }

        return $this->render("hello/formulario.html.twig", [
                'form' => $form->createView()        
        ]);
    }

}