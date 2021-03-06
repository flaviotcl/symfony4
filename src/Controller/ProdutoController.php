<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Form\ProdutoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProdutoController extends AbstractController
{
    /**
     * @Route("/produto/listar_produto", name="listar_produto")
     * @Template("produto/index.html.twig")
     */
    public function index()
    {
            $em = $this->getDoctrine()->getManager();

            $produtos  =  $em->getRepository(Produto::class)->findAll();

            return [
                'produtos' => $produtos
    ];
    }

    /**
     * @param Request $request
     * @Route("/produto/cadastrar", name="cadastrar_produto", methods={"GET","POST"})
     * @Template("produto/create.html.twig")
     */
    public function create(Request $request): Response
    {
        $produto = new Produto();
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em = $this->getDoctrine()->getManager();

            $em->persist($produto);
            $em->flush();

            //$this->get('session')->getFlashBag()->set('success','Produto foi salvo com sucesso !');
            $this->addFlash("success", "Produto Cadastrado !");

            return $this->redirectToRoute('listar_produto');
        }

        return $this->render("produto/create.html.twig",
            ['form' => $form->createView(),
                'produto'=> $produto]
            );
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("produto/editar/{id}", name="editar_produto")
     * @Template("produto/update.html.twig")
     */
    public function update(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $produto = $em->getRepository(Produto::class)->find($id);

        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $em->persist($produto);
            $em->flush();

            $this->get("session")->getFlashBag()->set("success","O Produto " .$produto->getNome() . " foi alterado com sucesso");
            return $this->redirectToRoute("listar_produto");
        }

        return  [
            'produto' => $produto,
            'form' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @Route("produto/visualizar/{id}", name="visualizar_produto")
     * @Template("produto/view.html.twig")
     */
    public function view(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($id);

        return  [
            'produto' => $produto
        ];
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @Route("produto/apagar/{id}", name="apagar_produto")
     */
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($id);

        if (!$produto)
        {
            $mensagem = "Produto não foi encontrado !";
            $tipo = "warning";
        } else {
            $em->remove($produto);
            $em->flush();

            $mensagem = "Produto foi excluído com sucesso !";
            $tipo= "success";
        }

        $this->get("session")->getFlashBag()->set($tipo, $mensagem);
        return $this->redirectToRoute("listar_produto");

    }
}
