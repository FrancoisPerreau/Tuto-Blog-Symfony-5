<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $articleRepository;
    private $categoryRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        // $articles = $this->articleRepository->findAll();
        $articles = $this->articleRepository->findBy([], ['createdAt' => 'DESC']);
        $categories = $this->categoryRepository->findAll();

        return $this->render("home/home.html.twig", [
            'pageTitle' => 'Accueil',
            'title' => 'Blog d\'actualité',
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/article/{id}", name="show_article")
     */
    public function showArticle(?Article $article): Response
    {
        if (!$article) return $this->redirectToRoute('home');

        return $this->render("showArticle/show.html.twig", [
            'pageTitle' => $article->getTitle(),
            'article' => $article,
        ]);
    }


    /**
     * @Route("/categorie/{id}", name="show_category_articles")
     */
    public function categoryAricles(?Category $category): Response
    {
        if (!$category) return $this->redirectToRoute('home');

        $articles = array_reverse($category->getArticles()->getValues());
        $categories = $this->categoryRepository->findAll();

        return $this->render("home/home.html.twig", [
            'pageTitle' => $category,
            'title' => $category,
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
}
