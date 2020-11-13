<?php

// namespace et use : pas encore expliqués
// TODO: explication namespace et use
// TODO: re-explication du MVC (que Denis, ce fainéant, n'a pas expliqué)
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;

// je créé une classe PagesController
// attention, cette classe doit avoir le même nom que le fichier qui la contient (majuscules etc)
// si la classe et le fichier n'ont pas le même nom, on obtient cette erreur :
// "Cannot declare class App\Controller\PageController, because the name is already in use"
// Le nom de la classe, dans un controleur, est suffixée par le mot "Controller"
class PagesController
{

    /**
     * On a du code dans une commentaire : c'est un annotation
     * cette annotation permet de créer une route : c'est à dire, une nouvelle URL sur notre site
     * La classe Route est appelée dans l'annotation, avec en premier parametre l'url de la route
     * à créer et en second parametre le nom de la route (qui doit être unique)
     * @Route("/contact", name="page_contact")
     */
    // on créé une méthode contact qui sera appelée quand l'url "/contact" (donc la route associée)
    // est appelée. Elle est appelée automatiquement car la route est définie au dessus de la méthode
    public function contact()
    {
        // j'execute un var_dump pour afficher du contenu sur ma page
        var_dump('affichage de la page contact');
        die;
    }

    /**
     * @Route("/blog", name="page_blog")
     */
    public function blog()
    {
        var_dump('hello blog');
        die;
    }

}
