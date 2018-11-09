<?php

namespace App\DataFixtures;

use App\Entity\Gallery;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $gallery = new Gallery();
        $gallery->setName('Architecture');
        $manager->persist($gallery);


        $gallery2 = new Gallery();
        $gallery2->setName('Paysages');
        $manager->persist($gallery2);


        $manager->flush();
    }
}
