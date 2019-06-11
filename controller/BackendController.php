<?php

namespace Controller;

use Model\CommentManager;
use Model\PostManager;
use Model\AdminManager;


class BackendController
{

    public $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('view\backend\templates');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function connexionPage()
    {
        \session_start();
        if (isset($_SESSION['username']) and isset($_SESSION['psw'])) {
            $username = $_SESSION['username'];
            $psw = $_SESSION['psw'];
            echo $this->twig->render("connexionInterface.twig", [
                'username' => $username,
                'psw' => $psw
            ]);
        } else {
            \session_start();
            echo $this->twig->render("connexionInterface.twig");
        }
    }

    public function accesRegister()
    {
        session_start();
        echo $this->twig->render("register.twig");
    }

    public function register()
    {
        $name = \htmlspecialchars($_POST['userName']);
        $psw = \htmlspecialchars($_POST['psw']);
        $confirmPsw = \htmlspecialchars($_POST['confirmPsw']);
        $email = \htmlspecialchars($_POST['email']);
        $emailChecked = filter_var($email, FILTER_VALIDATE_EMAIL);
        $uppercase = \preg_match('#[A-Z]#', $psw);
        $lowercase = \preg_match('#[a-z]#', $psw);
        $numberMin = \preg_match('#[0-9]#', $psw);


        if (isset($psw) and isset($confirmPsw) and isset($email) and isset($name)) {
            $adminManager = new AdminManager();
            $usersReq = $adminManager->getAllUsers();

            $usersData = $usersReq->fetchAll();

            foreach ($usersData as $user) {

                if ($user["username"] == $name) {
                    echo 'Le pseudo ' . $name . ' est deja utilise. <br> <a href="index.php?action=connexion"> Try Again</a>  Try Again</a> <br>';
                };
                $usersReq->closeCursor();

                if ($emailChecked !== $email) {
                    echo 'Votre adresse email : ' . $email . ', est incorrecte. <br> <a href="index.php?action=connexion"> Try Again</a> <br>';
                } else {
                    if ($user["email"] == $email) {
                        echo 'L\'email ' . $email . ' est deja utilise. <br> <a href="index.php?action=connexion"> Try Again</a> <br>';
                    };
                    $usersReq->closeCursor();
                };
            };

            if ($psw != $confirmPsw || !$uppercase || !$lowercase || !$numberMin || \strlen($psw) < 6) {
                echo 'Le mot de passe est incorrect. <br> <a href="index.php?action=connexion"> Try Again</a> <br>';
            } else {
                $adminManager->registerUser($name, $psw, $email);
                \session_start();
                echo $this->twig->render("homeAdmin.twig");
            };
        };
    }

    public function signIn()
    {
        $userName = htmlspecialchars($_POST['username']);
        $psw = htmlspecialchars($_POST['psw']);

        $adminManager = new AdminManager();
        $userData = $adminManager->getPsw($userName);

        $isPasswordCorrect = password_verify($psw, $userData['psw']);

        if ($userData['username'] !== $userName) {
            echo 'Mauvais identifiant <br> <a href="index.php?action=connexion"> Try Again</a> <br>';
        } else {
            if (!$isPasswordCorrect) {
                echo 'Mot de passe incorrect <br> <a href="index.php?action=connexion"> Try Again</a> <br>';
            } elseif (isset($_POST['rememberMe'])) {
                \session_start();
                $_SESSION['isAuth'] = true;
                $_SESSION['username'] = $userName;
                $_SESSION['psw'] = $psw;

                echo $this->twig->render("homeAdmin.twig");
            } else {
                \session_start();
                $_SESSION['isAuth'] = true;
                echo $this->twig->render("homeAdmin.twig");
            }
        }
    }
}
