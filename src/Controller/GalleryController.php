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
    public function index(EntityManagerInterface $em, Environment $twig): Response
    {
        $galleries = $em->getRepository(Gallery::class)->findAllWithImages();


        if(empty($galleries)){
            throw new \Exception('Il n\'y a pas encore de photo dans cet album.');
        }

        return new Response($twig->render('gallery/GalleryByAlbum.html.twig', array(

            'galleries' => $galleries
        )));
    }

    /**
     * @param $id
     * @param EntityManagerInterface $em
     * @param Environment $twig
     * @return Response
     * Return all thumbnails of id gallery
     */
    public function thumbnailsList(int $id, EntityManagerInterface $em, Environment $twig):Response
    {
        $gallery = $em->getRepository(Gallery::class)->findByIdWithImages($id);
        $gallery = $gallery[0];

        if (empty($gallery)){
            throw new \Exception('Un problème est survenu avec l\'affichage des thumbnails');
        }


        return new Response($twig->render('gallery/thumbGallery.html.twig', array(
            'gallery' => $gallery
        )));

    }
}