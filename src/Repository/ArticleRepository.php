<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function searchInTitle($search)
    {
        // je créé le query builder qui me permet de construire
        // ma requête
        $qb = $this->createQueryBuilder('a');

        // je sélectionne tous les articles
        $query = $qb->select('a')
            // à condition que leur titre contiennent le mot recherché
            ->where('a.title LIKE :search')
            // j'utilise le setParameter pour nettoyer la variable
            // contenant la recherche et ainsi éviter les attaques
            // types injection SQL
            ->setParameter('search', '%'.$search.'%')
            // je récupère la requête générée
            ->getQuery();

        // je retourne les résultats de la requête SQL
        return $query->getResult();
    }

}
