<?php

namespace App\Controller;


use App\Entity\Gallery;
use App\Entity\Like;
use App\Entity\LikeImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @param EntityManagerInterface $em
     * @param int $userId
     * @param int $imageId
     * @return Response
     * @throws \Exception
     * Register likes/dislikes in BDD if user click
     */
    public function likeImage(Request $request, EntityManagerInterface $em): Response
    {
        // if ajax request do this...
        if ($request->isXmlHttpRequest()){
            $userId = $request->get('userId');
            $imageId = $request->get('imageId');

            $rq = $em->getRepository(LikeImage::class)->findItem($userId, $imageId);

            // if image not liked, like, persist user and image liked into database
            if (count($rq) == 0){
                $like = new LikeImage();
                $like->setUserId($userId);
                $like->setImageId($imageId);

                $em->persist($like);
                $em->flush();

                $likeClassName = 'fa fa-heart fa-lg white-text heart';

            }else{
                // dislike and remove from database
                $em->remove($rq[0]);
                $em->flush();

                $likeClassName = 'fa fa-heart-o fa-lg white-text heart';
            }

        }else{
            throw new \Exception('Un problème inattendu est survenu...');
        }

        return new Response($likeClassName);


    }

}