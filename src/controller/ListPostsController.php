<?php
namespace Controller;

use Model\PostManager;


class ListPostsController
{

    public $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('src\view\frontend\templates');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function listPosts()
    {
        $postManager = new PostManager();
        $posts = $postManager->getPosts();
        $datas = $posts->fetchAll();

        echo  $this->twig->render("listPostView.twig", [
            'datas' => $datas,
        ]);
        $posts->closeCursor();
    }
}
