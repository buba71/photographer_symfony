<?php

namespace App\Services;

use App\Entity\LikeImage;
use Doctrine\ORM\EntityManagerInterface;

class likeDislikeImage
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function likeOrDislike(int $userId, int $imageId)
    {
        $currentImageLike = $this->entityManager->getRepository(LikeImage::class)->findItem($userId, $imageId);


        // if image not liked, like, persist user id and image liked  id into database
        if (count($currentImageLike) == 0){
            $like = new LikeImage();
            $like->setUserId($userId);
            $like->setImageId($imageId);


            $this->entityManager->persist($like);
            $this->entityManager->flush();

            $likeClassName = 'fa fa-heart fa-lg white-text heart';

        }else{
            // dislike and remove from database
            $this->entityManager->remove($currentImageLike[0]);
            $this->entityManager->flush();

            $likeClassName = 'fa fa-heart-o fa-lg white-text heart';
        }

        return $likeClassName;

    }
}