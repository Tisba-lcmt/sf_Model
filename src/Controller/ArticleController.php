<?php


namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
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


    /**
     * je créé une url avec une wildcard "id"
     * qui contiendra l'id d'un article
     * @Route("/article/show/{id}", name="article_show")
     *
     * en parametre de la méthode, je récupère la valeur de la wildcard id
     * et je demande en plus à symfony d'instancier pour moi
     * la classe ArticleRepository dans une variable $articleRepository
     * (autowire)
     */
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        // j'utilise l'articleRepository avec la méthode find
        // pour faire une requête SQL SELECT en BDD
        // et retrouver l'article dont l'id correspond à l'id passé en URL
        $article = $articleRepository->find($id);

        dump($article); die;
    }


    /**
     * @Route("/article/insert-static", name="article_insert_static")
     *
     * je demande à Symfony d'instancier pour moi la classe EntityManager (EntityManagerInterface)
     * dans une variable $entityManger. Cette classe permet de faire les requêtes INSERT, UPDATE et DELETE
     *
     */
    public function insertStaticArticle(EntityManagerInterface $entityManager)
    {

        // j'instancie la classe d'entité Article
        // pour pouvoir définir les valeurs de ses propriétés (et donc créer un nouvel enregistrement
        // dans la table article en BDD)
        $article = new Article();

        // Je définis les valeurs des propriétés de l'entité Article
        // qui seront les valeurs des colonnes correspondantes en BDD
        $article->setTitle("Titre de mon article");
        $article->setContent("contenu de mon article");
        $article->setImage("https://www.lapiscine.pro/wp-content/uploads/2017/05/LaPiscine_2017_BDX.jpg");
        $article->setCreationDate(new \DateTime());
        $article->setPublicationDate(new \DateTime());
        $article->setIsPublished(true);

        // j'utilise la méthode persist de l'EntityManager pour "pré-sauvegarder" mon entité (un peu comme un commit
        // dans Git)
        $entityManager->persist($article);

        // j'utilise la méthode flush de l'EntityManager pour insérer en BDD toutes les entités
        // "pré-sauvegardées" (persistées)
        $entityManager->flush();

        // j'affiche le rendu d'un fichier twig
        return $this->render('article/insert_static.html.twig');
    }

}
