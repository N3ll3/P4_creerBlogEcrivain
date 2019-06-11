<?php

use Controller\FrontendController;
use Controller\BackendController;

require('vendor/autoload.php');

$frontendController = new FrontendController();
$backendController = new BackendController();

try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'listPosts':
                $frontendController->listPosts();
                break;
            case 'onePost':
                $frontendController->onePost();
                break;
            case 'addComment':
                $frontendController->addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                break;
            case 'flag':
                $frontendController->flagComment($_GET['idComment']);
                break;
            case 'connexion':
                $backendController->connexionPage();
                break;
            case 'register':
                $backendController->register();
                break;
            case 'signIn':
                $backendController->signIn();
                break;
            case 'accesRegister':
                $backendController->accesRegister();
                break;
            default;
                $frontendController->listPosts();
                break;
        }
    } else {
        $frontendController->listPosts();
    }
} catch (\Exception $e) {
    $errorMessage = $e->getMessage();
    // require('view/errorView.php');
    echo 'Erreur : ' . $e->getMessage();
}
