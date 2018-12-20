<?php

namespace App\Form\DataTransformer;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;


class TagsTansformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param mixed $value
     * @return string
     * @ convert array tags from the easyAdmin form into string for displaying
     */
    public function transform($value):string
    {
        return implode(',', $value);
    }

    /**
     * @param mixed $value
     * @return array
     * @ Convert string tags from the easyAdmin form TagsType into array
     */
    public function reverseTransform($value):array
    {
        $inputStringTags = explode(',' , $value);
        $arrayTags = [];

        // Delete empty values, duplicate values and spaces
        $formatInputStringTags = array_unique(
            array_filter(array_map('trim', $inputStringTags))
        );

        foreach ($formatInputStringTags as $tagName){
            $newTag = new Tag();
            $newTag->setName($tagName);
            $arrayTags[] = $newTag;
        }

        return $arrayTags;

    }
}