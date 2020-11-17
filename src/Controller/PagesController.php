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




}
