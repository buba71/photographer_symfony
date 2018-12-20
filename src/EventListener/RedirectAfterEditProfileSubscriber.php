<?php

namespace App\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;


class RedirectAfterEditProfileSubscriber implements EventSubscriberInterface
{
    private $routeur;
    private $session;

    public function __construct(RouterInterface $router, FlashBagInterface $session)
    {
        $this->routeur = $router;
        $this->session = $session;
    }

    public function onEditProfileSuccess(FormEvent $event)
    {
        $this->session->add('notice', 'Vos informations ont été modifiées avec succès!');
        $url = $this->routeur->generate('user_account');
        $response = new RedirectResponse($url);
        $event->setResponse($response);

    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onEditProfileSuccess'
        ];
    }
}