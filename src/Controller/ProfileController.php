<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{

    /**
     * @Route("/profile", name="profile_show")
     */
    public function profileShow()
    {
        $profile = [
            "firstname" => "Flantier",
            "name" => "Noel",
            "age" => 40,
            "job" => "secret agent",
            "active" => false
        ];

        return $this->render('profile.html.twig', [
            'profile' => $profile
        ]);
    }

    /**
     * @Route("/missions", name="missions")
     */
    public function missions()
    {
        // je créé un tableau qui pourra être bouclé
        $missions = ['Brésil', 'Egypte', 'Afrique Noire'];

        return $this->render('missions.html.twig', [
           'missions' => $missions
        ]);
    }

}
