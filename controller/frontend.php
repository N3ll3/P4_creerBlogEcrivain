<?php

// Chargement des classes
use Model\PostManager;
use Model\CommentManager;

require_once('vendor/autoload.php');

function loadTwig()
{
    $loader = new Twig_Loader_Filesystem('view\frontend\templates');
    return new Twig_Environment($loader, [
        'debug' => true,
        'cache' => false /*__DIR__.'/view/frontend/tmp'*/
    ]);
}

function listPosts()
{
    $postManager = new PostManager(); // Création d'un objet
    $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
    $twig = loadTwig();
    $twig->addExtension(new \Twig\Extension\DebugExtension());
    $datas = $posts->fetchAll();

    echo  $twig->render("listPostView.twig", [
        'datas' => $datas
    ]);
    $posts->closeCursor();
}

function post()
{
    $postManager = new PostManager();
    $commentManager = new CommentManager();

    $postData = $postManager->getPost($_GET['id']);
    $commentsData = $commentManager->getComments($_GET['id']);
    // $post = $postData->fetch();
    $comments = $commentsData->fetchAll();

    $twig = loadTwig();
    $twig->addExtension(new \Twig\Extension\DebugExtension());

    echo  $twig->render("OnePostView.twig", [
        'post' => $postData,
        'comments' => $comments
    ]);
}

function addComment($postId, $author, $comment)
{
    $commentManager = new CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}
