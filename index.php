<?php

use Controller\ListPostsController;
use Controller\CommentsController;
use Controller\ConnexionController;
use Controller\RegisterController;
use Controller\HomeAdminController;
use Controller\WritePostController;
use Controller\ModerateCommentController;

require('vendor/autoload.php');
\session_start();

// Init controllers
$listPostsController = new ListPostsController();
$commentsController = new CommentsController();
$connexionController = new ConnexionController();
$registerController = new RegisterController();
$homeAdminController = new HomeAdminController();
$writePostController = new WritePostController();
$moderateCommentController = new ModerateCommentController();

try {
    if (isset($_GET['action'])) {

        switch ($_GET['action']) {

                // Public

                // Page Listing Posts
            case 'listPosts':
                $listPostsController->listPosts();
                break;

                // Page One POst and Comments
            case 'onePost':
                $commentsController->onePost();
                break;
            case 'addComment':
                $commentsController->addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                break;
            case 'flag':
                $commentsController->flagComment($_GET['idComment']);
                break;

                // Admin

                // Page Connexion
            case 'connexion':
                $connexionController->connexion();
                break;

            case 'signIn':
                $connexionController->signIn();
                break;

                // Page Home Admin
            case 'writePostAcces':
                $homeAdminController->accesWritePost();
                break;
            case 'logout':
                $homeAdminController->logout();
                break;
            case 'modifyPostAcces':
                $homeAdminController->accesModifyPost();
                break;

                // Page Write Post
            case 'writePost':
                $writePostController->writePost($_POST['title'], $_POST['content']);
                break;

            case 'modifyPost':
                $writePostController->modifyPost($_POST['title'], $_POST['content'], $_GET['idPost']);
                break;

                // Page Moderate comment
            case 'moderateComment':
                $moderateCommentController->listFlaggedComments();
                break;

            case 'deleteComment':
                $moderateCommentController->deleteComment($_GET['idComment']);
                break;

            case 'unflagComment':
                $moderateCommentController->approveComment($_GET['idComment']);
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
