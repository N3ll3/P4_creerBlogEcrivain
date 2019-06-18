<?php

namespace Helpers;

class TwigHelper
{
    private static $_instance = null;
    private $twig;

    private function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(['view\backend\templates', 'view\templates']);
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new TwigHelper();
        }
        return self::$_instance;
    }
}
