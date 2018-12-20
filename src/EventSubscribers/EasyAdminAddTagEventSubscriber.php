<?php

namespace App\EventSubscribers;


use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EasyAdminAddTagEventSubscriber implements EventSubscriberInterface
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    /**
     * @return array
     * @subscriber on easyAdmin pre_update and pre_persist entity event
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            'easy_admin.pre_update'  => array('filterSetArticleTags'),
            'easy_admin.pre_persist' => array('filterSetArticleTags')
        );
    }

    /**
     * @param GenericEvent $event
     * @ Avoid duplicate Tags on Bdd
     * @ intercept new entity from the form and check if it not contain tags already registered into Bdd
     */
    public function filterSetArticleTags(GenericEvent $event):void
    {
        $entity = $event->getSubject();

        if(!($entity instanceof Article)) {
            return;
        }

        // if entity = Article get oldTags(in BDD)
        // And check if the new Article entity not contain a tag witch is already registered into Bdd
        $oldTags = $this->manager->getRepository(Tag::class)->findAll();

        foreach ($oldTags as $oldTag){
            foreach (($entity->getTags()) as $tag) {

                // if tag already exist on bdd, remove and use old tag
                if ($tag->getName() == $oldTag->getName()){

                    $entity->removeTag($tag);
                    $entity->addTag($oldTag);

                }else{

                    $entity->addTag($tag);

                }
            }
        }

    }
}