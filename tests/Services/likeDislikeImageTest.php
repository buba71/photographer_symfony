<?php

namespace tests\Services;



use App\Entity\LikeImage;
use App\Services\likeDislikeImage;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class likeDislikeImageTest extends TestCase
{

    private $em;
    private $likeImageRepository;

    public function setUp()
    {
        $this->em = static::createMock(EntityManagerInterface::class);
        $this->likeImageRepository = static::createMock('App\Repository\LikeImageRepository');
    }


    public function testImageAllReadyLiked():void
    {
        $userId = 1;
        $imageId = 5;

        $likeImage = new LikeImage();
        $likeImage->setUserId($userId);
        $likeImage->setImageId($imageId);


        $this->likeImageRepository->expects($this->any())
            ->method('findItem')
            // findItem method repository return object "LikeImage" if image liked and remove it from bdd
            ->willReturn([$likeImage]);

        $this->em->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->likeImageRepository);


        $likeImage = new likeDislikeImage($this->em);

        $result = $likeImage->likeOrDislike($userId, $imageId);

        static::assertContains('fa fa-heart-o fa-lg white-text heart', $result);
    }

    public function testImageNotLiked():void
    {
        $userId = 1;
        $imageId = 5;

        $this->likeImageRepository->expects($this->any())
            ->method('findItem')
            // findItem method repository return none if image not liked and set
            ->willReturn([]);

        $this->em->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->likeImageRepository);


        $likeImage = new likeDislikeImage($this->em);

        $result = $likeImage->likeOrDislike($userId, $imageId);

        static::assertContains('fa fa-heart fa-lg white-text heart', $result);

    }

}