<?php

namespace App\Services;

use App\Entity\LikeImage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class likeDislikeImage
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function likeOrDislike($userId, $imageId)
    {
        $currentImageLike = $this->em->getRepository(LikeImage::class)->findItem($userId, $imageId);
        // if image not liked, like, persist user id and image liked  id into database
        if (count($currentImageLike) == 0){
            $like = new LikeImage();
            $like->setUserId($userId);
            $like->setImageId($imageId);

            $this->em->persist($like);
            $this->em->flush();

            $likeClassName = 'fa fa-heart fa-lg white-text heart';

        }else{
            // dislike and remove from database
            $this->em->remove($currentImageLike[0]);
            $this->em->flush();

            $likeClassName = 'fa fa-heart-o fa-lg white-text heart';
        }

        return $likeClassName;

    }
}