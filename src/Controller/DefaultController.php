<?php

namespace App\Controller;

use App\Entity\Gallery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


class DefaultController
{
    /**
     * @param EntityManagerInterface $em
     * @param Environment $twig
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(EntityManagerInterface $em, Environment $twig)
    {
        $sliderImages = $em->getRepository(Gallery::class)->findAllWithImages();


        return new Response($twig->render('base.html.twig', array(
            'sliderImages' => $sliderImages
        )));
    }
}