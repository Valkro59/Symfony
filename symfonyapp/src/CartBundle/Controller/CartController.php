<?php

namespace CartBundle\Controller;

use CartBundle\Entity\Cart;
use CartBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * @Route("/add/{id}", name="cart_add", requirements={"id"="\d+"})
     */
    public function addAction($id)
    {
        $repo = $this->getDoctrine()
            ->getRepository('CartBundle:Product');

        $product = $repo->find($id);
        $session = $this->get('session');

        if (!$session->has('cart')) {
            $session->set('cart', new Cart());
        }

        $session->get('cart')->addProduct($product);

        $this->addFlash('success', 'Le produit a bien été ajouté au panier');

        return $this->redirectToRoute('cart_index');

    }

    /**
     * @Route("/clear", name="cart_clear")
     */
    public function clearAction()
    {
        $this->get('session')->get('cart')->clear();
        $this->addFlash('success', 'Le panier a bien été vidé, HASTA LA VISTA BABY');
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/remove{id}", name="cart_remove", requirements={"id"="\d+"})
     */
    public function removeAction($id)
    {
        $repo = $this->getDoctrine()
            ->getRepository('CartBundle:Product');

        $product = $repo->find($id);
        $session = $this->get('session');

        if (!$session->has('cart')) {
            $session->set('cart', new Cart());
        }
        try {
            $session->get('cart')->removeProduct($product);
        } catch (Exception $e) {
            $this->addFlash('danger', 'Non, pourquoi tant de haine et d\'injustice!');
        }
        return $this->redirectToRoute('cart_index');
    }


}
