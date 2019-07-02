<?php

namespace Controller;

use Model\PostManager;
use Model\CommentManager;
use Controller\Controller;


class PostsController extends Controller
{
    public function listPosts()
    {
        $postPerPage = 5;
        $postManager = new PostManager();
        $nbPosts = $postManager->getNbOfAllPosts();
        $nbOfPage = ceil(intval($nbPosts) / $postPerPage);
        $page = 1;
        if (isset($_GET['page']) and $_GET['page'] <= $nbOfPage) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $firstPost = ($page - 1) * $postPerPage;

        $posts = $postManager->getFivePosts($firstPost, $postPerPage);

        $twig = $this->launchTwig();

        echo  $twig->render("listPostView.twig", [
            'datas' => $posts,
            'nbPage' => $nbOfPage
        ]);
    }

    public function onePost()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $postManager = new PostManager();
            $commentManager = new CommentManager();
            $post = $postManager->getPost($_GET['id']);
            $posts = $postManager->getAllPosts();
            $currentIdPost = $_GET['id'];
            $indexCurrentPost = array_search($currentIdPost, array_column($posts, "id"));
            $nbPosts = count($posts);

            if ($indexCurrentPost < $nbPosts - 1) {
                $indexNextPost = $indexCurrentPost + 1;
                $idNextPost = $posts[$indexNextPost]['id'];
            } elseif ($indexCurrentPost >= $nbPosts - 1) {
                $idNextPost = '0';
            }

            $commentsData = $commentManager->getComments($_GET['id']);

            $twig = $this->launchTwig();
            echo  $twig->render("OnePostView.twig", [
                'post' => $post,
                'comments' => $commentsData,
                'nextPost' => $idNextPost
            ]);
        } else {
            throw new \Exception('Aucun identifiant de billet envoyé');
        }
    }

    public function publishPost($title, $content)
    {

        if (!empty($_POST['title']) and !empty($_POST['content'])) {

            $postManager = new PostManager();
            $newPost = $postManager->publishPost($title, $content);

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
