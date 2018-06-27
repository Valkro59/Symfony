<?php

namespace CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/product/add", name="cart_product_add" )
     *
     */
    public function addAction(Request $request)
    {

        $form = $this->createForm('CartBundle\Form\Type\ProductType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success','Produit ajouté avec succés');
            $this->redirectToRoute('cart_product_add');
        }

        return $this->render('@Cart/Product/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
