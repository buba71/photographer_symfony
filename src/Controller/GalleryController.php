<?php

namespace App\Controller;


use App\Entity\Gallery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


class GalleryController
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param Environment $twig
     * @return Response
     * Return the last image insered in each Album
     */
    public function index(EntityManagerInterface $entityManager, Environment $twig): Response
    {
        $galleries = $entityManager->getRepository(Gallery::class)->findAllWithImages();

        if(empty($galleries)){
            throw new \Exception('Il n\'y a pas encore de photo dans cet album.');
        }

        return new Response($twig->render('gallery/GalleryByAlbum.html.twig', array(
            'galleries' => $galleries,

        )));
    }

    public function thumbnailsList($id)
    {

    }
}