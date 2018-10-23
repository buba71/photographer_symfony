<?php

namespace App\EventSubscribers;

use App\Entity\Image;
use App\Entity\LikeImage;

use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class LikeEventSubscriber implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preRemove
        );
    }

    public function prePersist(LifecycleEventArgs $args):void
    {
        $entity = $args->getObject();
        $em = $args->getObjectManager();

        if(!$entity instanceof LikeImage){
            return;
        }

        $imageId = $entity->getImageId();

        $image = $em->getRepository(Image::class)->findOneBy(array('id' => $imageId));
        $numberOfLike = $image->getNumberOfLike();

        $addLike = $numberOfLike + 1;
        $image->setNumberOfLike($addLike);
        $em->flush();
    }

    public function preRemove(LifecycleEventArgs $args):void
    {
        $entity =$args->getObject();
        $em =$args->getObjectManager();

        if(!$entity instanceof LikeImage){
            return;
        }

        $imageId = $entity->getImageId();

        $image = $em->getRepository(Image::class)->findOneBy(array('id' => $imageId));
        $numberOfLike = $image->getNumberOfLike();

        $subLike = $numberOfLike - 1;
        $image->setNumberOfLike($subLike);
        $em->flush();

    }
}