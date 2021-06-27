<?php

namespace src\tienda_virtual\controllers;

use src\tienda_virtual\services\TwigPageFinderService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class IndexController extends Controller
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
        $this->pageFinderService->findFileRute("index");
    }
}