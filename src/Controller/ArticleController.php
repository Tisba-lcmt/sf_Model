<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * je créé une route avec dans l'url une "wildcard"
     * qui sera remplie par l'utilisateur après /article/ dans l'url
     * @Route("/article/{id}", name="article_show")
     *
     * je mets en parametre de la méthode une variable $id (dont le nom
     * correspond à la wildcard créée) pour demander à Symfony
     * de mettre la valeur de la wildcard dans la variable
     */
    public function articleShow($id)
    {
        // simulation d'une requête en BDD qui récupère tous les articles
        // c'est un array (tableau) à index numérique
        $articles = [
            1 => 'Article 1',
            2 => "Article 2",
            3 => "Article 3",
            4 => 'Article 4',
            5 => "Article 5",
            6 => "Article 6",
        ];

        // je récupère l'article dans l'array $articles
        // en fonction de l'id passé en url
        $article = $articles[$id];

        // j'utilise la méthode render (issue de l'AbstractController)
        // qui va récupérer un fichier twig (dans le dossier templates)
        // puis le compiler en HTML et le renvoyer en tant que réponse HTTP

        // je passe en second parametre de la méthode render
        // un tableau (array) qui contient toutes les variables
        // que je veux utiliser dans twig
        // Tant que je n'envoie pas les variables au fichier twig
        // je ne peux pas les appeler car c'est un fichier séparé
        return $this->render('article.html.twig', [
            'article' => $article
        ]);
    }


    /**
     * @Route("/article/form-process", name="form_process")
     */
    public function processForm()
    {
        // variable à modifier pour simuler l'envoi d'un formulaire
        $isFormSubmitted = true;

        // si le formulaire n'a pas été envoyé
        if (!$isFormSubmitted) {
            return new Response('Merci de remplir le formulaire');
        } else {
            // j'utilise la méthode redirectToRoute
            // qui est définie non pas dans la classe actuelle,
            // mais dans la classe AbstractController que la classe actuelle étend
            // cette méthode permet de faire une redirection vers une page
            // en utilisant le nom de la route
            return $this->redirectToRoute("home");
        }
    }
}
