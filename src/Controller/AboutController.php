<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AboutController
{
    public function index(Environment $twig):Response
    {
        return new Response($twig->render('about/about.html.twig'));
    }
}