<?php

namespace Src\Classes;

/**
 * Classe que rederiza paginas HTML utilizando Twig
 */
class View
{

    # +-----------------------------------------------------------------------+
    # | renderiza template utilizando Twig                                    |
    # +-----------------------------------------------------------------------+
    public static function render($template, $args = [])
    {
        static $twig = null;
        if ($twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader(DIR_PROJECT . 'app/View');
            $twig = new \Twig\Environment($loader);
        }
        echo $twig->render($template, $args);
    }

}
