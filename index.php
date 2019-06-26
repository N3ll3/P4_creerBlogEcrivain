<?php

use Controller\PostsController;
use Controller\CommentsController;
use Controller\AdminController;


require('vendor/autoload.php');
\session_start();

// Init controllers
$postsController = new PostsController();
$commentsController = new CommentsController();
$adminController = new AdminController();

try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
                // Public

                // Page Listing Posts
            case 'listPosts':
                $postsController->listPosts();
                break;

                // Page One POst and Comments
            case 'onePost':
                $postsController->onePost();
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
                $adminController->connexion();
                break;

            case 'signIn':
                $adminController->signIn();
                break;

                // Page Home Admin
            case 'writePostAcces':
                $adminController->accesWritePost();
                break;
            case 'logout':
                $adminController->logout();
                break;

                // Page Write Post
            case 'publishPost':
                $postsController->publishPost($_POST['title'], $_POST['content']);
                break;

            case 'modifyPost':
                $postsController->modifyPost($_POST['title'], $_POST['content'], $_GET['idPost']);
                break;

            case 'savePost':
                $postsController->savePost($_POST['title'], $_POST['content']);
                break;

            case 'deletePost':
                $postsController->deletePost($_GET['idPost']);
                break;


                // Page Moderate comment
            case 'moderateComment':
                $commentsController->listFlaggedComments();
                break;

            case 'deleteComment':
                $commentsController->deleteComment($_GET['idComment']);
                break;

            case 'unflagComment':
                $commentsController->approveComment($_GET['idComment']);
                break;

                //Default
            default;
                $postsController->listPosts();
                break;
        }
    } else {
        $postsController->listPosts();
    }
} catch (\Exception $e) {
    $errorMessage = $e->getMessage();
    // require('view/errorView.php');
    echo 'Erreur : ' . $e->getMessage();
}
