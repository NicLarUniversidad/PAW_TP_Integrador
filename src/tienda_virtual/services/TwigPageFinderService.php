<?php


namespace src\tienda_virtual\services;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use src\tienda_virtual\services\UserService;

class TwigPageFinderService extends PageFinderService
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function findFileRute(string $name, string $folder = "html", string $type = "html",
                                 Array $cssImports = [], Array $data = [], string $title = "tienda virtual", $jsImports = []) : void {
        //$user = $this->session->get(UserService::$USER_SESSION_NAME);
        //require __DIR__ . "\\..\\views\\" . $folder . "\\" . $name . "." . $type;
        $loader = new FilesystemLoader( __DIR__ . '/../views/twig');
        $twig = new Environment($loader, ['auto_reload' => true, 'debug' => true]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $user = $this->session->get(UserService::$USER_SESSION_NAME);        
        echo $twig->render($name . ".twig", compact("data", "cssImports",
            "jsImports", "title","user"));
    }
}