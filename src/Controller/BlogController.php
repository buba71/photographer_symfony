<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class BlogController
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param Environment $twig
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @ Return a list of posts
     */
    public function index(EntityManagerInterface $entityManager, Environment $twig, Request $request, PaginatorInterface $paginator): Response
    {
        $tags = $entityManager->getRepository(Tag::class)->findAll();
        // if request contain a search tag request, display this posts
        if ($request->get('tag')){

            $tag = $request->get('tag');
            $posts = $entityManager->getRepository(Article::class)->findPostsByTag($tag);

        // else if request not contain search tag request display all posts
        }else{

            $posts = $entityManager->getRepository(Article::class)->findPostsWithTags();

        }
        // Use paginator Bundle: default page, 1; limit per page, 6
        $postsList = $paginator->paginate($posts,
            $request->query->getInt('page', 1),
            2);

        return new Response($twig->render('blog/postsList.html.twig', array(
            'postsList' => $postsList,
            'tags'      => $tags
        )));
    }

    /**
     * @param Request $request
     * @param RouterInterface $router
     * @param EntityManagerInterface $entityManager
     * @param Environment $twig
     * @param Session $session
     * @param Security $security
     * @param FormFactoryInterface $formFactory
     * @param int $id
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * Return the post and comments list on $id post request
     */
    public function showPost(Request $request, RouterInterface $router, EntityManagerInterface $entityManager, Environment $twig, Session $session, Security $security,FormFactoryInterface $formFactory, int $id): Response
    {
        // retrieve the selected post with id = $id
        $post = $entityManager->getRepository(Article::class)->find($id);
        if(null == $post){
            throw new NotFoundHttpException('Cet article n\'éxiste pas');
        }

        // retrieve all comments of this post
        $comments = $entityManager->getRepository(Comment::class)->findBy(array('article' => $post));

        $user =$security->getUser();
        $comment = new Comment();

        // Create form comments
        $form = $formFactory->createBuilder(CommentType::class, $comment)->getForm();
        $form->handleRequest($request);

        // if form is submitted
        if ($form->isSubmitted() && $form->isValid()){

            // set comment with respective post and user
            $comment->setArticle($post);
            $comment->setUser($user);

            $entityManager->persist($comment);
            $entityManager->flush();

            // on success, display message
            $session->getFlashBag()->add('notice', 'Votre commentaire a été ajouté avec succès!');
            $url= $router->generate('show_post', array('id'=>$id));
            return new RedirectResponse($url);
        }

        return new Response($twig->render('blog/showPost.html.twig', array(
            'post' => $post,
            'comments' => $comments,
            'form' => $form->createView()
        )));
    }
}
