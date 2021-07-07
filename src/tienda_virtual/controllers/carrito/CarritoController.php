<?php


namespace src\tienda_virtual\controllers\carrito;


use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\services\TwigPageFinderService;

class CarritoController extends Controller
{
    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
    }
    public function mostrarTemplate(String $notificacion = "", array $data = [], String $titulo = "Carrito") {
        $this->pageFinderService->findFileRute("carrito","twig","twig", [],
            $data,$titulo, []);
    }
}