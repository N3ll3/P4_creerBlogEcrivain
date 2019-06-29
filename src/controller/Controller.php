<?php

namespace Controller;

class Controller

{
    protected function launchTwig()
    {
        $loader = new \Twig\Loader\FilesystemLoader('src\view\templates');
        $twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal('session', $_SESSION);

        return $twig;
    }
}
