<?php

namespace Controller;

use Model\AdminManager;
use Model\CommentManager;
use Model\PostManager;
use Helper\TwigLoader;

class AdminController extends TwigLoader
{
    public function connexion()
    {
        $twig = $this->launchTwig();
        if (isset($_SESSION['isAuth'])) {
            $commentManager = new CommentManager();
            $postManager = new PostManager();
            $chapWIP = $postManager->getChapWIP();
            $nbCommentFlagged = $commentManager->getNumberOfCommentsFlagged();

            echo $twig->render("homeAdmin.twig", [
                'nbCommentFlagged' => $nbCommentFlagged,
                'datas' => $chapWIP
            ]);
        } else {
            echo $twig->render("connexionInterface.twig");
        }
    }

    public function signIn()
    {
        $userName = htmlspecialchars($_POST['username']);
        $psw = htmlspecialchars($_POST['psw']);

        $adminManager = new AdminManager();
        $userData = $adminManager->getPsw($userName);

        $isPasswordCorrect = password_verify($psw, $userData['psw']);

        if ($userData['username'] !== $userName) {
            echo 'Mauvais identifiant <br> <a href="index.php?action=connexion"> Try Again</a> <br>';
        } else {
            if (!$isPasswordCorrect) {
                echo 'Mot de passe incorrect <br> <a href="index.php?action=connexion"> Try Again</a> <br>';
            } else {
                $_SESSION['isAuth'] = true;
                \header('Location:index.php?action=connexion');
            }
        }
    }

    public function accesWritePost()
    {
        $twig = $this->launchTwig();

        if (isset($_SESSION['isAuth'])) {
            if (isset($_GET['idPost'])) {
                $idPost = $_GET['idPost'];
                $postManager = new PostManager();
                $postSelected = $postManager->getPost($idPost);
                echo $twig->render("writePost.twig", ['post' => $postSelected]);
            } else {
                echo $twig->render("writePost.twig");
            }
        } else {
            echo $twig->render("connexionInterface.twig");
        }
    }

    public function accesModerateComment()
    {
        $twig = $this->launchTwig();

        if (isset($_SESSION['isAuth'])) {
            echo $twig->render("moderateComment.twig");
        } else {
            echo $twig->render("connexionInterface.twig");
        }
    }

    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        header('Location:index.php?action=listPosts');
    }
}
