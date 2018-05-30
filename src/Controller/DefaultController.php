<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{
    public function index()
    {
        phpinfo();
        $die = 56;
        echo $die;
        return $this->render('base.html.twig');
    }
}