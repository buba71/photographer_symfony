<?php

namespace App\Controller;


use App\Entity\Image;
use App\Entity\LikeImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class UserController
{
    public function index(Environment $twig, EntityManagerInterface $em, Security $security, Session $session):Response
    {
        // User must be authenticated
        if($security->isGranted('ROLE_USER')){
            $itemList = array();

            $user = $security->getUser()->getId();

            // retrieve list of images liked by user
            $imagesLiked = $em->getRepository(LikeImage::class)->findBy(array('user_id'=> $user));

            // if not images liked display flash message
            if(empty($imagesLiked)){
                $session->getFlashBag()->add('notice', 'Vous n\'avez pas encore aimé de photo.');
            }


            foreach ($imagesLiked as $like){
                $imageId = $like->getImageId();
                $likeDate = $like->getCreatedAt();
                $image = $em->getRepository(Image::class)->find($imageId);

                // Store image object and date of like in $item array
                $item = array(
                    'image'    => $image,
                    'likeDate' => $likeDate
                );

                $itemList[] = $item;
            }

            return new Response($twig->render('user/account.html.twig',array(
                'itemList' => $itemList
            )));
        }

        // user not authenticated
        return new Response('Vous n\'avez pas accès à cet espace.');

    }
}