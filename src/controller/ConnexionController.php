<?php
namespace Controller;

use Model\AdminManager;

class ConnexionController
{
    public $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('src\view\templates');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function connexion()
    {
        if (isset($_SESSION['isAuth'])) {
            echo $this->twig->render("homeAdmin.twig");
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
            } else {
                $_SESSION['isAuth'] = true;
                \header('Location:index.php?action=connexion');
            }
        }
    }
}