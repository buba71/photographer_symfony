<?php

namespace App\Services;

use App\Entity\Image;
use App\Entity\LikeImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class getUserAccount
{
    private $em;
    private $session;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session =$session;
    }

    public function getUserInfo($currentUser)
    {
        $itemList= array();
        // retrieve list of images liked by user from bdd
        $imagesLiked = $this->em->getRepository(LikeImage::class)->findBy(array('user_id'=> $currentUser));

        // if not images liked display flash message
        if(empty($imagesLiked)){
            $this->session->getFlashBag()->add('notice', 'Vous n\'avez pas encore aimé de photo.');
        }


        foreach ($imagesLiked as $like){
            $imageId = $like->getImageId();
            $likeDate = $like->getCreatedAt();
            $image = $this->em->getRepository(Image::class)->find($imageId);

            // Store image object and date of like in $item array
            $item = array(
                'image'    => $image,
                'likeDate' => $likeDate
            );

            $itemList[] = $item;
        }

        return $itemList;

    }
}