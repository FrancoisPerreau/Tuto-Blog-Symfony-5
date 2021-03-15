<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $articles = $this->articleRepository->findAll();

        return $this->render("home/home.html.twig", [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{id}", name="show_article")
     */
    public function show(Article $article): Response
    {
        if (!$article) return $this->redirectToRoute('home');

        return $this->render("showArticle/show.html.twig", [
            'article' => $article,
        ]);
    }
}
