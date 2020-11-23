<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

// J'ai créé une base de données en modifiant la variable DATABASE_URL
// du fichier .env.local (que j'ai créé en copiant le fichier .env)
// puis en utilisant la ligne de commande doctrine:database:create

// J'ai créé une classe Product qui est une entité car elle possède l'annotation
// @ORM\Entity

/**
 * @ORM\Entity()
 */
class Product
{

    // J'ai créé autant de propriétés que de colonnes voulues dans la table
    // et j'ai mappé les propriétés avec des annotations et la classe ORM (attention
    // de ne pas oublier le use correspondant)
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

}
