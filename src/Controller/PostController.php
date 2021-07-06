<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index(): Response
    {
        return $this->render('post/index.html.twig');
    }

    /**
     * @Route ("/posts", name="app_blog_posts")
     */
    public function showPosts(PostRepository $postRepository) : Response
    {
        $posts = $postRepository->findAll();
        
        return $this->render('blog/posts.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route ("/post/{id<\d+>}", name="app_blog_showOnePost")
     */
    public function showOnePost(PostRepository $postRepository, $id) : Response
    {
        $post = $postRepository->find($id);
        
        return $this->render('blog/posts.html.twig', [
            'post' => $post,
        ]);
    }
}
