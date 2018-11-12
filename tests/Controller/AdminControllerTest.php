<?php

namespace tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    /**
     * @var
     */
    private $entitymanager;

    /**
     * @var
     */
    private $usermanager;

    /**
     * @ Setting-up kernel, entityManager
     */
    public function setUp():void
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->entitymanager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->usermanager = $kernel->getContainer()->get('fos_user.user_manager');

    }

    /**
     * @ Create a new user from fosUer bundle
     * @ return void
     */
    public function testCreateNewUserEntity():void
    {
       $user = $this->usermanager->createUser();

        $user->setUsername('test');
        $user->setEmail('test@gmail.com');
        $user->setPlainPassword('test');

        $this->usermanager->updateUser($user);

        $userRepository = $this->usermanager->findUserBy(array(
            'username' => 'test'
        ));

        static::assertEquals('test', $userRepository->getUsername());

    }


}