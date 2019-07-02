<?php

namespace Controller;

use Model\AdminManager;
use Model\CommentManager;
use Model\PostManager;
use Controller\TwigSingleton;

class AdminController
{
    public function connexion()
    {
        if (isset($_SESSION['isAuth'])) {
            $commentManager = new CommentManager();
            $postManager = new PostManager();
            $chapDraft = $postManager->getChapDraft();
            $nbCommentFlagged = $commentManager->getNumberOfCommentsFlagged();

            echo TwigSingleton::getTwig()->render("homeAdmin.twig", [
                'nbCommentFlagged' => $nbCommentFlagged,
                'datas' => $chapDraft
            ]);
        } else {
            echo TwigSingleton::getTwig()->render("connexionInterface.twig");
        }
    }

    public function signIn()
    {
        $userName = \htmlspecialchars($_POST['username']);
        $password = \htmlspecialchars($_POST['psw']);

        $adminManager = new AdminManager();
        $userData = $adminManager->getPassword($userName);

        $isPasswordCorrect = \password_verify($password, $userData['psw']);

        if ($userData['username'] !== $userName) {
            echo 'Mauvais identifiant <br> <a href="index.php?action=connexion"> Réessayer</a> <br>';
        } else {
            if (!$isPasswordCorrect) {
                echo 'Mot de passe incorrect <br> <a href="index.php?action=connexion"> Réessayer</a> <br>';
            } else {
                $_SESSION['isAuth'] = true;
                \header('Location:index.php?action=connexion');
            }
        }
    }

    public function accesChangePassword()
    {
        if (isset($_SESSION['isAuth'])) {
            echo TwigSingleton::getTwig()->render("changePassword.twig");
        } else {
            echo TwigSingleton::getTwig()->render("connexionInterface.twig");
        }
    }

    public function logout()
    {
        $_SESSION = array();
        \session_destroy();
        \header('Location:index.php?action=listPosts');
    }

    public function changePassword()
    {
        $userName = \htmlspecialchars($_POST['username']);
        $newPassword = \htmlspecialchars($_POST['newpassword']);
        if (isset($userName) && isset($newPassword)) {
            $passwordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $adminManager = new AdminManager();
            $adminManager->updatePasswordUser($passwordHashed, $userName);
        } else {
            throw new \Exception('Votre mot de passe n\' a pu être changé');
        }
    }
}
