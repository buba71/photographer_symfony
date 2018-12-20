<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 19/12/2018
 * Time: 20:48
 */

namespace App\tests\EventSubscribers;

use App\Entity\Article;
use App\Entity\Tag;
use App\EventSubscribers\EasyAdminAddTagEventSubscriber;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\GenericEvent;

class EasyAdminAddTagEventSubscriberTest extends TestCase
{
    private $entityManager;
    private $repository;

    public function setUp()
    {
        $this->repository = static::createMock(ObjectRepository::class);
        $this->entityManager = static::createMock(EntityManagerInterface::class);

    }

    // Add tag if not already exist
    public function testWhenTagsNotExist():void
    {
        // Post to create
        $post  = new Article();

        // Init post with this tag
        $tag = new Tag();
        $tag->setName('photo');
        $post->addTag($tag);
        
        // Create event
        $event = new GenericEvent($post);

        // Tags in Bdd
        $tagArray = [];

        // Stub of tags repository (findAll)
        $this->repository->expects($this->any())
            ->method('findAll')
            ->willReturn($tagArray);

        // Stub of  the repository
        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->repository);

        $filterEventAction = new EasyAdminAddTagEventSubscriber($this->entityManager);
        $filterEventAction->filterSetArticleTags($event);

        static::assertSame('photo', $tag->getName());
    }

    public function testWhenTagAlreadyExist()
    {
        // Post to create
        $post  = new Article();

        // init new post with this tag
        $tag = new Tag();
        $tag->setName('photo');
        $post->addTag($tag);

        // Create event
        $event = new GenericEvent($post);

        // Tags in Bdd
        $tag_1 = new Tag();
        $tag_1->setName('photo');
        $tag_2 = new Tag();
        $tag_2->setName('video');
        $tagArray = [$tag_1, $tag_2];

        // Stub of tags repository (findAll)
        $this->repository->expects($this->any())
            ->method('findAll')
            ->willReturn($tagArray);

        // Stub of  the repository
        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->repository);

        $filterEventAction = new EasyAdminAddTagEventSubscriber($this->entityManager);
        $filterEventAction->filterSetArticleTags($event);

        static::assertContains($tag_1, $post->getTags());
        static::assertCount(1, $post->getTags());

    }

}
