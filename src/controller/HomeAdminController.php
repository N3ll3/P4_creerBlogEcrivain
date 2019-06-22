<?php
namespace Controller;

use Model\PostManager;
use Model\CommentManager;

class HomeAdminController
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

    public function accesWritePost()
    {
        if (isset($_SESSION['isAuth'])) {

            echo $this->twig->render("writePost.twig");
        } else {
            echo $this->twig->render("connexionInterface.twig");
        }
    }

    public function accesModifyPost()
    {
        if (isset($_SESSION['isAuth'])) {
            $idPost = $_GET['idPost'];
            $postManager = new PostManager();
            $postSelected = $postManager->getPost($idPost);
            echo $this->twig->render("modifyPost.twig", ['post' => $postSelected]);
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
