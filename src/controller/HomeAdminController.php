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

    public function writePostAcces()
    {
        echo $this->twig->render("writePost.twig");
    }

    public function moderateComment()
    {
        echo $this->twig->render("moderateComment.twig");
    }

    public function logout()
    {
        unset($_SESSION); // js
        header('Location:index.php?action=listPosts');
    }
}
