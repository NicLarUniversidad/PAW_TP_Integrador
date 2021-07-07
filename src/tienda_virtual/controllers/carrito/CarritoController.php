<?php


namespace src\tienda_virtual\controllers\carrito;


use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\services\TwigPageFinderService;

class CarritoController extends Controller
{
    protected CarritoService $carritoService;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->carritoService = new CarritoService($this->connection, $this->logger);
        $this->carritoService->setSession($this->session);
        $this->carritoService->init();

    }

    public function mostrarTemplate(String $notificacion = "", array $data = [], String $titulo = "Carrito") {
        $data = $this->carritoService->findItems($data);
        $this->pageFinderService->findFileRute("carrito","twig","twig", [],
            $data,$titulo, []);
    }
}