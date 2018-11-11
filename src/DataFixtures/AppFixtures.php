<?php

namespace App\DataFixtures;

use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use FOS\UserBundle\Model\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Handler\DownloadHandler;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;


class AppFixtures extends Fixture
{
    private $fosUserManager;

    public function __construct(UserManagerInterface $fosUserManager)
    {
        $this->fosUserManager = $fosUserManager;
    }


    public function load(ObjectManager $manager):void
    {
        // gallery fixtures
        $gallery = new Gallery();

        $gallery->setName('Architecture');
        $manager->persist($gallery);

        //Image fixtures
        // Avoid deleting original image by vichUploader
        copy(__DIR__.'/../../public/build/images/imageTest.jpg', __DIR__.'/../../public/tmp/imageTest.jpg');

        $image = new Image();

        $imageFile = new UploadedFile('public/tmp/imageTest.jpg', 'imageTest.jpg', 'image/jpg', null, true);

        $image->setGallery($gallery);
        $image->setImage('imageTest');
        $image->setImageFile($imageFile);
        $image->setNumberOfLike(0);

        $manager->persist($image);


        //user fixtures
        $user = $this->fosUserManager->createUser();
        $user->setUsername('John');
        $user->setEmail('jhon@gmail.com');
        $user->setPlainPassword('john');
        $user->setRoles(array('ROLE_USER'));
        $user->setEnabled(true);

        $this->fosUserManager->updateUser($user);


        $manager->flush();
    }
}
