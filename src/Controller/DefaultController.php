<?php

namespace App\Controller;

use App\Entity\Gallery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


class DefaultController
{
    public function index(EntityManagerInterface $em, Environment $twig)
    {
        $sliderImages = $em->getRepository(Gallery::class)->findAllWithImages();


        return new Response($twig->render('base.html.twig', array(
            'sliderImages' => $sliderImages
        )));
    }
}