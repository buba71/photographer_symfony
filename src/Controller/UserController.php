<?php

namespace App\Controller;




use App\Services\getUserAccount;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class UserController
{
    /**
     * @param Environment $twig
     * @param Security $security
     * @param getUserAccount $getUserAccount
     * @return Response
     * Display user info and images liked into user account
     */
    public function index(Environment $twig, Security $security, getUserAccount $getUserAccount):Response
    {
        // User must be authenticated
        if($security->isGranted('ROLE_USER')){

            $user = $security->getUser()->getId();

            // contains  images liked list by date
            $itemList = $getUserAccount->getUserInfo($user);


            return new Response($twig->render('user/account.html.twig',array(
                'itemList' => $itemList
            )));
        }

        // user not authenticated
        return new Response('Vous n\'avez pas accès à cet espace.');

    }
}