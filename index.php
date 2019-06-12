<?php

use Controller\ListPostsController;
use Controller\CommentsController;
use Controller\ConnexionController;
use Controller\RegisterController;
use Controller\HomeAdminController;
use Controller\WritePostController;

require('vendor/autoload.php');

// Init controllers
$listPostsController = new ListPostsController();
$commentsController = new CommentsController();
$connexionController = new ConnexionController();
$registerController = new RegisterController();
$homeAdminController = new HomeAdminController();
$writePostController = new WritePostController();

try {
    if (isset($_GET['action'])) {

        switch ($_GET['action']) {

                // FrontEnd
            case 'listPosts':
                $listPostController->listPosts();
                break;
            case 'onePost':
                $commentsController->onePost();
                break;
            case 'addComment':
                $commentsController->addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                break;
            case 'flag':
                $commentsController->flagComment($_GET['idComment']);
                break;

                // Backend
            case 'connexion':
                $connexionController->connexionPage();
                break;
            case 'signIn':
                $connexionController->signIn();
                break;
            case 'accesRegister':
                $connnexionController->accesRegister();
                break;

            case 'register':
                $registerController->register();
                break;

            case 'writePostAcces':
                $homeAdminController->writePostAcces();
                break;
            case 'logout':
                $homeAdminController->logout();
                break;

            case 'writePost':
                $writePostController->writePost($_POST['title'], $_POST['content']);
                break;

                //Default
            default;
                $listPostsController->listPosts();
                break;
        }
    } else {
        $listPostsController->listPosts();
    }
} catch (\Exception $e) {
    $errorMessage = $e->getMessage();
    // require('view/errorView.php');
    echo 'Erreur : ' . $e->getMessage();
}
