<?php
namespace Controller;

use Model\AdminManager;
use Model\CommentManager;
use Model\PostManager;

class AdminController
{
    public $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('src\view\templates');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function connexion()
    {
        if (isset($_SESSION['isAuth'])) {
            $commentManager = new CommentManager();
            $postManager = new PostManager();
            $chapWIP = $postManager->getChapWIP();
            $nbCommentFlagged = $commentManager->getNumberOfCommentsFlagged();
            echo $this->twig->render("homeAdmin.twig", [
                'nbCommentFlagged' => $nbCommentFlagged,
                'datas' => $chapWIP
            ]);
        } else {
            echo $this->twig->render("connexionInterface.twig");
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
        if (isset($_SESSION['isAuth'])) {
            if (isset($_GET['idPost'])) {
                $idPost = $_GET['idPost'];
                $postManager = new PostManager();
                $postSelected = $postManager->getPost($idPost);
                echo $this->twig->render("writePost.twig", ['post' => $postSelected]);
            } else {
                echo $this->twig->render("writePost.twig");
            }
        } else {
            echo $this->twig->render("connexionInterface.twig");
        }
    }

    public function accesModerateComment()
    {
        if (isset($_SESSION['isAuth'])) {
            echo $this->twig->render("moderateComment.twig");
        } else {
            echo $this->twig->render("connexionInterface.twig");
        }
    }

    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        header('Location:index.php?action=listPosts');
    }
}
