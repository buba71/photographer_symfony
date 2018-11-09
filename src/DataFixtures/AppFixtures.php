<?php

namespace App\DataFixtures;

use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // gallery fixtures
        $gallery = new Gallery();
        $gallery->setName('Architecture');
        $manager->persist($gallery);


        $gallery2 = new Gallery();
        $gallery2->setName('Paysages');
        $manager->persist($gallery2);

        $user = new User();
        $user->setUsername('Lucie');
        $user->setPassword('lucie');


        $manager->flush();
    }
}
