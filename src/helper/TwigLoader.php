<?php

namespace Helper;

class TwigLoader

{
    protected function launchTwig()
    {
        $loader = new \Twig\Loader\FilesystemLoader('src\view\templates');
        $twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        return $twig;
    }
}
