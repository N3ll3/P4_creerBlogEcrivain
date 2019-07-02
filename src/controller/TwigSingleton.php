<?php

namespace Controller;

class TwigSingleton

{
    private static $twig;

    static function getTwig()
    {
        if (!self::$twig) {
            $loader = new \Twig\Loader\FilesystemLoader('src/view/templates');
            self::$twig = new \Twig\Environment($loader, [
                'debug' => true,
                'cache' => false
            ]);
            self::$twig->addExtension(new \Twig\Extension\DebugExtension());
            self::$twig->addGlobal('session', $_SESSION);
        }
        return self::$twig;
    }
}
