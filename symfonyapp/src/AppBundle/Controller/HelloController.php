<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class HelloController extends Controller
{
    /**
     * @Route("/bonjour", name="sayhello" )
     */
    public function SayHelloAction()
    {
        return $this->render('@App/Hello/sayhello.html.twig');
    }
}




