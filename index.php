<?php
use Controller\FrontendController;

require_once('vendor/autoload.php');

$frontendController = new FrontendController();

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            $frontendController->listPosts();
        } elseif ($_GET['action'] == 'onePost') {
            $frontendController->onePost();
        } elseif ($_GET['action'] == 'addComment') {
            $frontendController->addComment($_GET['id'], $_POST['author'], $_POST['comment']);
        } elseif ($_GET['action'] == 'flag') {
            $frontendController->flagComment($_GET['idComment']);
        }
    } else {
        $frontendController->listPosts();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    require('view/errorView.php');
    echo 'Erreur : ' . $e->getMessage();
}

  // elseif ($_GET['action'] == 'comment') {
        //     if (isset($_GET['idComment']) && $_GET['idComment'] > 0 && isset($_GET['postId']) && $_GET['postId'] > 0) {
        //         $frontendController->comment($_GET['idComment']);
        //     } else {
        //         // Erreur ! On arrête tout, on envoie une exception, donc au saute directement au catch
        //         throw new Exception('Aucun identifiant de commentaire envoyé');
        //     }
        // } elseif ($_GET['action'] == 'edit') {
        //     if (isset($_GET['idComment']) && $_GET['idComment'] > 0) {
        //         if (!empty($_POST['modifiedComment'])) {
        //             $frontendController->editComment($_POST['modifiedComment'], $_GET['idComment'], $_GET['postId']);
        //         } else {
        //             // Autre exception
        //             throw new Exception('Tous les champs ne sont pas remplis !');
        //         }
        //      }
        // } 
