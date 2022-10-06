<?php

namespace src\tienda_virtual\controllers;

use src\tienda_virtual\services\TwigPageFinderService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use src\tienda_virtual\services\UserService;

class PageNotFoundException extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pageFinderService = new TwigPageFinderService();
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function get() {
        $cssImports = Array();
        $cssImports[] = "main";
        $jsImports[]="app";
        array_push($jsImports, "paw");
        // $data=["usuario" => "fede"];
        //$this->pageFinderService->findFileRute("index","html","html", $cssImports,[],"tienda virtual",$jsImports);
        //$this->pageFinderService->findFileRute("index");
        $this->pageFinderService->findFileRute("server-error","twig","twig", $cssImports,[],"tienda virtual",$jsImports);
    }
}