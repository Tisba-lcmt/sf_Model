<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    // la ligne de commande bin/console make:form m'a permis de générer automatiquement ce fichier
    // c'est un gabarit de formulaire pour l'entité que j'ai spécifié en ligne de commande
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('title')
            ->add('content')
            ->add('image')
            ->add('publicationDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('creationDate', DateType::class, [
                'widget' => 'single_text'
            ])
            // dans mon gabarit de formulaire, je créé "l'input" category
            // relié à ma propriété category dans l'entité Article
            // Vu que c'est une relation vers une autre entité (une autre table)
            // je lui passe en type "EntityType"
            ->add('category', EntityType::class, [
                // je reprécise quelle entité je veux afficher dans mon input
                // ici c'est Category donc ça affichera toutes les catégories dans
                // une liste déroulante
                'class' => Category::class,
                // Dans la liste déroulante, je choisis la propriété à afficher pour
                // chacune des catégories (il faut qu'elle permette à l'utilisateur
                // d'identifer et de choisir une catégorie)
                'choice_label' => 'title'
            ])
            ->add('isPublished')
            ->add('sauver', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
