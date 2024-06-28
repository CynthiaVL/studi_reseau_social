<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PostController extends AbstractController
{
    #[Route('/', name:'home')]
    public function index(ManagerRegistry $doctrine, UserInterface $user = null): Response
    {
        $repository = $doctrine->getRepository(Post::class);
        $posts = $repository->findAll();
        return $this->render('post/index.html.twig',[
            "posts" => $posts,
            "user" => $user,
        ]);
    }

    #[Route('/post/create', name: 'createPost')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        if ($this->getUser()) {
            $post = new Post();
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $post->setUser($this->getUser());
                $em = $doctrine->getManager();
                $em->persist($post);
                $em->flush();
                return $this->redirectToRoute('home');
            }
            return $this->render('post/form.html.twig',[
                "post_form" => $form->createView()
            ]);
        }
        return $this->redirectToRoute('home');
    }

    #[Route('/post/edit/{id<\d+>}', name: 'editPost')]
    public function update(ManagerRegistry $doctrine, Request $request, Post $post): Response
    {
        if ($this->getUser() && $this->getUser()->getId() === $post->getUser()->getId()) {
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $em = $doctrine->getManager();
                $em->flush();
                return $this->redirectToRoute('home');
            }
            return $this->render('post/form.html.twig',[
                "post_form" => $form->createView()
            ]);
        }
        return $this->redirectToRoute('home');
    }

    #[Route('/post/delete/{id<\d+>}', name:'deletePost')]
    public function delete(Post $post, ManagerRegistry $doctrine) : Response
    {   
        if ($this->getUser() && $this->getUser()->getId() === $post->getUser()->getId()) {
            $em = $doctrine->getManager();
            $em->remove($post);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        return $this->redirectToRoute('home');
    }

}
