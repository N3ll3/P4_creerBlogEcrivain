<?php
namespace Controller;


class HomeAdminController
{
    public $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('src\view\backend\templates');
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

    public function accesModerateComment()
    {
        if (isset($_SESSION['isAuth'])) {
            echo $this->twig->render("writePost.twig");
        } else {
            echo $this->twig->render("moderateComment.twig");
        }
    }

    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        header('Location:index.php?action=listPosts');
    }
}
