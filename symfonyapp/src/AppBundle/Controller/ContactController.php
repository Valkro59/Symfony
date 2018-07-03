<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\VarDumper\VarDumper;

class ContactController extends Controller
{
    /**
     * @Route("/contact/list", name="app_contact_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Contact');
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $repo->findAllMessages(),
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('@App/Contact/list.html.twig', [
            'pagination' => $pagination]);

    }

    /**
     * @Route("/contact", name="Contact" )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ContactAction(Request $request)
    {
        $contact = new Contact();

        $form = $this->createFormBuilder($contact)
            ->add('email',EmailType::class, ['attr' => ['placeholder' => 'salutJeanClaude@aware.com']])
            ->add('firstname',TextType::class)
            ->add('lastname',TextType::class)
            ->add('message', TextareaType::class)
            ->add('message2', TextareaType::class)
            ->add('btnsend', SubmitType::class, ['label' => 'Envoyer'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ici on envoie un email
            //ou on sauvegarde en base de données

            $contact = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash('success','Votre message a bien été envoyé');
            $this->addFlash('info','Bien joué gros !');
            $this->addFlash('danger','C\'est la merde, fuyez pauvre fou !');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('@App/Contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

