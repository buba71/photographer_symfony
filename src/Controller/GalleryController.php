<?php

namespace App\Controller;


use App\Entity\Gallery;

use App\Entity\LikeImage;
use App\Services\likeDislikeImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
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
            throw new \Exception('Cette gallerie ne contient pas de photos.');
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
    public function thumbnailsList(int $id, EntityManagerInterface $em, Environment $twig, Security $security ):Response
    {
        $imagesLiked = array();

        if ($security->getUser()){
            $user = $security->getUser()->getId();
            $imagesLiked = $em->getRepository(LikeImage::class)->findBy(array('user_id'=> $user));
        }

        // return an array with the images of gallery id
        $gallery = $em->getRepository(Gallery::class)->findByIdWithImages($id);
        // Get first element of query
        $gallery = $gallery[0];

        if (empty($gallery)){
            throw new \Exception('Cette gallerie ne contient pas de photos');
        }

        return new Response($twig->render('gallery/thumbGallery.html.twig', array(
            'gallery'     => $gallery,
            'imagesLiked' => $imagesLiked
        )));

    }

    /**
     * @param EntityManagerInterface $em
     * @param int $userId
     * @param int $imageId
     * @return Response
     * @throws \Exception
     * Register likes/dislikes in BDD if user click
     */
    public function likeImage(Request $request, likeDislikeImage $likeDislikeImage): Response
    {
        // if ajax request, do this...
        if ($request->isXmlHttpRequest()){
            $userId = $request->get('userId');
            $imageId = $request->get('imageId');

            if (isset($userId) && isset($imageId)){
                $likeClassName = $likeDislikeImage->likeOrDislike($userId, $imageId);
            }

            return new Response($likeClassName);

        }else{
            throw new \Exception('Un problème inattendu est survenu...');
        }

    }

}