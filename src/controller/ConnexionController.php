<?php
namespace Controller;

use Model\AdminManager;

class ConnexionController
{
    public $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('src\view\backend\templates');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function connexionPage()
    {

        if (isset($_SESSION['username']) and isset($_SESSION['psw'])) {
            $username = $_SESSION['username']; // cookies
            $psw = $_SESSION['psw']; //cookies
            echo $this->twig->render("connexionInterface.twig", [
                'username' => $username,
                'psw' => $psw
            ]);
        } else {
            echo $this->twig->render("connexionInterface.twig");
        }
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

                $_SESSION['isAuth'] = true;
                $_SESSION['username'] = $userName; //cookies localStorage js
                $_SESSION['psw'] = $psw; //hash

                echo $this->twig->render("homeAdmin.twig");
            } else {

                $_SESSION['isAuth'] = true;
                echo $this->twig->render("homeAdmin.twig");
            }
        }
    }

    public function accesRegister()
    {
        echo $this->twig->render("register.twig");
    }
}
