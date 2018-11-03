<?php

namespace App\Controller;


use App\Form\ContactType;
use App\Services\emailerContact;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class ContactController
{
    /**
     * @param Environment $twig
     * @param Response $response
     * Send an email to admin from any user
     */
    public function index(Request $request, Environment $twig, FormFactoryInterface $formFactory, RouterInterface $router,Session $session, emailerContact $mailer):Response
    {
        $form = $formFactory->createBuilder(ContactType::class)->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $contact = $form->getData();
            $mailer->contactEmail($contact);
            $session->getFlashBag()->add('notice', 'Votre message a été envoyé!');

            $url = $router->generate('contact');

            return new RedirectResponse($url);
        }

        return new Response($twig->render('contact/index.html.twig', array(
            'form' => $form->createView()
        )));
    }
}
