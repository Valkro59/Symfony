<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('CartBundle:Product');
        $products = $repo->findAll();

        // replace this example code with whatever you need
        return $this->render('@App/Default/index.html.twig', [
            'products' => $products,
        ]);
    }
}
