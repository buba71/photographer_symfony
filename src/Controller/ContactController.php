<?php

namespace App\Controller;


use App\Form\ContactType;
use App\Services\EmailerContact;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ContactController
{
    /**
     * @param Environment $twig
     * @param Response $response
     * @return mixed
     */
    public function index(Request $request, Environment $twig, FormFactoryInterface $formFactory, emailerContact $mailer):Response
    {
        $form = $formFactory->createBuilder(ContactType::class)->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $contact = $form->getData();
            $mailer->contactEmail($contact);
        }

        return new Response($twig->render('contact/index.html.twig', array(
            'form' => $form->createView()
        )));
    }
}
