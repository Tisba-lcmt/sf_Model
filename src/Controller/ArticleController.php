<?php


namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        // les afficher dans un fichier twig

        return $this->render('article/list_articles.html.twig', [
            'articles' => $articles
        ]);
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
     * @Route("/article/insert", name="article_insert")
     */
    public function insertArticle(Request $request, EntityManagerInterface $entityManager)
    {

        // Je créé une nouvelle instance de l'entité Article
        // pour créer un nouvel enregstrement en bdd
        $article = new Article();

        // je veux afficher un formulaire pour créer des articles
        // donc je viens récupérer le gabarit de formulaire ArticleType créé en ligne de commandes
        // en utilisant la méthode createForm de l'AbstractController (et je lui passe en parametre
        // le gabarit de formulaire à créer)
        // je lie mon formulaire à mon instance d'Article
        $form = $this->createForm(ArticleType::class, $article);

        // Je viens lier le formulaire créé
        // à la requête POST
        // de cette manière, je pourrai utiliser la variable $form
        // pour vérifier si les données POST ont été envoyées ou pas
        $form->handleRequest($request);

        // si le form a été envoyé et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // alors je l'enregistre en BDD
            $entityManager->persist($article);
            $entityManager->flush();
        }

        // je prends le gabarit de formulaire récupéré et je créé une "vue" de formulaire avec
        // ce qui me permet de pouvoir afficher le formulaire html dans twig
        $formView = $form->createView();

        // j'envoie la vue de mon formulaire à twig
        return $this->render('article/insert.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete")
     *
     * je récupère la wildcard de l'url dans le parametre $id
     * je demande à SF d'instancier les classes ArticleRepository et
     * EntityManager (autowire)
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        // je récupère en bdd l'article dont l'id correspond à celui passé en url (wildcard)
        $article = $articleRepository->find($id);

        // si cet article existe en bdd (donc que la valeut d'$article n'est pas "null"
        // alors je le supprime avec la méthode remove de l'entityManager
        if (!is_null($article)) {
            $entityManager->remove($article);
            $entityManager->flush();

            // si j'ai bien supprimé mon article
            // j'ajoute un message flash de type "succès"
            // et je lui définis un message
            $this->addFlash(
                "success",
                "GRAND SUCCES !!!"
            );
        }

        // je fais une redirection vers la page de liste d'article
        // une fois la suppression faite
        return $this->redirectToRoute("article_list");
    }

}
