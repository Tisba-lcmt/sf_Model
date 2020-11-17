<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// J'étends la classe AbstractController de Symfony
// pour bénéficier des méthodes qui sont définies à l'intérieur
class PagesController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return new Response("Page d'accueil");
    }

    /**
     * @Route("/age", name="page_age")
     *
     * Je récupère une instance de la classe Request que
     * je demande à symfony de mettre dans une variable
     *
     * La classe Request de Symfony me permet de récupérer
     * toutes les infos possibles sur l'utilisateur (variables GET, POST,
     * adresse IP, cookies etc)
     */
    public function age(Request $request)
    {
        // la classe Request de Symfony possède des méthodes et
        // des propriétés pour récupérer les données de la requête
        // pour les variables GET, c'est la propriété query qu'il
        // faut utiliser
        $age = $request->query->get('age');

        //$request->query = permet de récupérer les parametres de requete GET
        // $request->request = permet de récuperer les données envoyées en POST

        // Je créé une instance de la classe Response
        // qui a pour contenu une chaine de caractères (avec un h1 etc)
        // Je stocke le resultat dans une variable $response
        $response = new Response('<h1>Hello David</h1>');

        // je retourne la variable $response qui contient ma Réponse HTTP
        return $response;
    }


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

        // je créé une réponse HTTP contenant la valeur de l'article
        // qui correspond à la wildcard id passée en URL

        $response = new Response('<h1>'.$articles[$id].'</h1>');

        // je retourne ma réponse
        return $response;
    }


    /**
     * @Route("/form-process", name="form_process")
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
