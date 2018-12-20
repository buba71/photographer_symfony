<?php

namespace App\tests\Form\DataTransformer;

use App\Form\DataTransformer\TagsTansformer;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class TagsTransformerTest extends TestCase
{
    public function getMockedTransformer()
    {
        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        return new TagsTansformer($entityManager);
    }
    public function testCreateTagsSArrayToString():void
    {
        $transformer = $this->getMockedTransformer();
        $tags = $transformer->transform(['photo', 'video']);

        static::assertSame('photo,video', $tags);
    }

    public function testCreateTagsStringToArray():void
    {
        $transformer = $this->getMockedTransformer();
        $tags = $transformer->reverseTransform('photo,video');

        static::assertCount(2, $tags);

    }
}