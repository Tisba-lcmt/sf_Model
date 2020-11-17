<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController
{

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
}
