<?php
namespace Controller;

use Model\PostManager;
use Model\CommentManager;


class PostsController
{

    public $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('src\view\templates');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function listPosts()
    {
        $postManager = new PostManager();
        $posts = $postManager->getAllPosts();
        echo  $this->twig->render("listPostView.twig", [
            'datas' => $posts,
        ]);
    }

    public function onePost()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $postManager = new PostManager();
            $commentManager = new CommentManager();
            $post = $postManager->getPost($_GET['id']);
            $commentsData = $commentManager->getComments($_GET['id']);

            echo  $this->twig->render("OnePostView.twig", [
                'post' => $post,
                'comments' => $commentsData
            ]);
        } else {
            throw new \Exception('Aucun identifiant de billet envoyé');
        }
    }

    public function publishPost($title, $content)
    {
        if (!empty($_POST['title']) and !empty($_POST['content'])) {
            $postManager = new PostManager();
            $newPost = $postManager->insertPost($title, $content);
            if (
                $newPost === false
            ) {
                throw new \Exception('Impossible d\'ajouter le nouvel article');
            } else {
                header('Location:index.php?action=listPosts');
            }
        } else {
            throw new \Exception('Tous les champs ne sont pas remplis !');
        }
    }

    public function modifyPost($title, $content, $idPost)
    {
        if (!empty($_POST['title']) and !empty($_POST['content'])) {
            $postManager = new PostManager();
            $modifiedPost = $postManager->modifyPost($title, $content, $idPost);
            if (
                $modifiedPost === false
            ) {
                throw new \Exception('Impossible de modifier l\'article');
            } else {
                header('Location:index.php?action=listPosts');
            }
        } else {
            throw new \Exception('Tous les champs ne sont pas remplis !');
        }
    }

    public function savePost($title, $content)
    {
        if (!empty($_POST['title']) and !empty($_POST['content'])) {
            $postManager = new PostManager();
            $savedPost = $postManager->savePost($title, $content);
            if ($savedPost == false) {
                throw new \Exception('Impossible de sauvegarder le chapitre');
            } else {
                header('Location:index.php?action=connexion');
            }
        } else {
            throw new \Exception('Tous les champs ne sont pas remplis !');
        }
    }

    public function deletePost($idPost)
    {
        if (isset($_GET['idPost'])) {
            $postManager = new PostManager();
            $deletePost = $postManager->deletePost($idPost);

            if ($deletePost == false) {
                throw new \Exception('Impossible de supprimer le chapitre');
            } else {
                header('Location:index.php?action=connexion');
            }
        } else {
            throw new \Exception('Le chapitre à supprimer n\'est pas indiqué');
        }
    }
}
