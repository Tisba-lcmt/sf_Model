<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
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

        var_dump($age);
        die;
    }
}
