<?php
use Controller\FrontendController;

require_once('vendor/autoload.php');




$frontendController = new FrontendController();

try { // On essaie de faire des choses
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            $frontendController->listPosts();
        } elseif ($_GET['action'] == 'onePost') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $frontendController->onePost();
            } else {
                // Erreur ! On arrête tout, on envoie une exception, donc au saute directement au catch
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    $frontendController->addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                } else {
                    // Autre exception
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            } else {
                // Autre exception
                throw new Exception('Aucun identifiant de billet envoyé');
            }
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
        elseif ($_GET['action'] == 'flag') {
            if (isset($_GET['idComment']) && $_GET['idComment'] > 0) {
                $frontendController->flagComment($_GET['idComment']);
            } else {
                throw new Exception('Ce commentaire ne peut etre signale');
            }
        } else {
            // Autre exception
            throw new Exception('Aucun identifiant de billet envoyé');
        }
    } else {
        $frontendController->listPosts();
    }
} catch (Exception $e) { // S'il y a eu une erreur, alors...
    $errorMessage = $e->getMessage();
    // require('view/errorView.php');
    echo 'Erreur : ' . $e->getMessage();
}
