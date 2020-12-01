<?php


namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminArticleController extends AbstractController
{

    /**
     * @Route("admin/article/list", name="admin_article_list")
     */
    public function articleList(ArticleRepository $articleRepository)
    {

        // récupérer tous les articles de ma table article
        // pour ça, j'utilise la classe générée automatiquement par SF
        // qui s'appelle ArticleRepository
        // et qui me permet de faire des requêtes SELECT en BDD
        // la méthode findAll() de la classe ArticleRepository me permet
        // de récupérer tous les éléments de la table Article
        $articles = $articleRepository->findAll();

        // les afficher dans un fichier twig

        return $this->render('article/admin/list_articles.html.twig', [
            'articles' => $articles
        ]);
    }


    /**
     * @Route("admin/article/insert", name="admin_article_insert")
     */
    public function insertArticle(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    )
    {

        // Je créé une nouvelle instance de l'entité Article
        // pour créer un nouvel enregstrement en bdd
        $article = new Article();

        // je veux afficher un formulaire pour créer des articles
        // donc je viens récupérer le gabarit de formulaire ArticleType créé en ligne de commandes
        // en utilisant la méthode createForm de l'AbstractController (et je lui passe en parametre
        // le gabarit de formulaire à créer)
        // je lie mon formulaire à mon instance d'Article
        $form = $this->createForm(ArticleType::class, $article);

        // Je viens lier le formulaire créé
        // à la requête POST
        // de cette manière, je pourrai utiliser la variable $form
        // pour vérifier si les données POST ont été envoyées ou pas
        $form->handleRequest($request);

        // si le form a été envoyé et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            // je récupère mon fichier uploadé dans le formulaire (vu que dans le gabarit
            // de formulaire, j'ai mis ce champs à 'mapped => false"
            $imageFile = $form->get('imageFileName')->getData();

            // si j'ai bien récupéré une image (il peut y avoir des articles
            // uploadés sans image), alors je vais la déplacer puis enregistrer son nom en bdd
            if ($imageFile) {

                // je récupère le nom de l'image
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                // grâce à la classe Slugger, je transforme le nom de mon image
                // pour sortir tous les caractères spéciaux (espaces etc)
                $safeFilename = $slugger->slug($originalFilename);

                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();


                // je déplace l'image dans un dossier que j'ai spécifié en parametre
                // (dans le fichier config/services.yaml)
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                // une fois que j'ai déplacé l'image, j'enregistre le nom de l'image
                // dans mon entité (pour qu'elle soit sauvée en bdd)
                $article->setImageFileName($newFilename);
            }

            // alors je l'enregistre en BDD
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                "success",
                "L'article a été ajouté !"
            );

            return $this->redirectToRoute('admin_article_list');
        }

        // je prends le gabarit de formulaire récupéré et je créé une "vue" de formulaire avec
        // ce qui me permet de pouvoir afficher le formulaire html dans twig
        $formView = $form->createView();

        // j'envoie la vue de mon formulaire à twig
        return $this->render('article/admin/insert.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("admin/article/update/{id}", name="admin_article_update")
     */
    public function updateArticle(
        $id,
        ArticleRepository $articleRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ) {
        $article = $articleRepository->find($id);

        if (is_null($article)) {
            return $this->redirectToRoute('admin_article_list');
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                "success",
                "L'article a été modifié !"
            );

            return $this->redirectToRoute('admin_article_list');
        }

        $formView = $form->createView();

        return $this->render('article/admin/update.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("admin/article/delete/{id}", name="admin_article_delete")
     *
     * je récupère la wildcard de l'url dans le parametre $id
     * je demande à SF d'instancier les classes ArticleRepository et
     * EntityManager (autowire)
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        // je récupère en bdd l'article dont l'id correspond à celui passé en url (wildcard)
        $article = $articleRepository->find($id);

        // si cet article existe en bdd (donc que la valeut d'$article n'est pas "null"
        // alors je le supprime avec la méthode remove de l'entityManager
        if (!is_null($article)) {
            $entityManager->remove($article);
            $entityManager->flush();

            // si j'ai bien supprimé mon article
            // j'ajoute un message flash de type "succès"
            // et je lui définis un message
            $this->addFlash(
                "success",
                "L'article a été supprimé"
            );
        }

        // je fais une redirection vers la page de liste d'article
        // une fois la suppression faite
        return $this->redirectToRoute("admin_article_list");
    }

}
