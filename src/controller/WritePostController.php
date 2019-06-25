<?php
namespace Controller;

use Model\PostManager;


class WritePostController
{

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
}
