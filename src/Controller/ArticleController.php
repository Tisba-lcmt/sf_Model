<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/article/list", name="article_list")
     */
    public function articleList(ArticleRepository $articleRepository)
    {
        // récupérer tous les articles de ma table article
        // pour ça, j'utilise la classe générée automatiquement par SF
        // qui s'appelle ArticleRepository
        // et qui me permet de faire des requêtes SELECT en BDD
        // la méthode findAll() de la classe ArticleRepository me permet
        // de récupérer tous les éléments de la table Article
        $articles = $articleRepository->findAll();

        dump($articles); die;

        // les afficher dans un fichier twig
    }

}
