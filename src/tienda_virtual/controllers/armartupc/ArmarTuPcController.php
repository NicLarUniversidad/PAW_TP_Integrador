<?php


namespace src\tienda_virtual\controllers\armartupc;


use src\tienda_virtual\controllers\carrito\CarritoController;
use src\tienda_virtual\database\services\categories\ArmarPCFlujoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\services\ArmarPCService;
use src\tienda_virtual\services\TwigPageFinderService;

class ArmarTuPcController extends \src\tienda_virtual\controllers\Controller
{
    protected ArmarPCService $service;
    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->service = new ArmarPCService();
        $this->service->setSession($this->session);
        $this->service->setConnection($this->connection);
        $this->service->setLogger($this->logger);
        $this->service->init();
    }
    public function mostrarTemplate(String $notificacion = "", array $data = [], String $titulo = "Armá tu PC") {
        $procesado = $this->request->get("procesado") ?? "";
        if ($procesado=="") {
            $paso = $this->request->get("paso") ?? "";
            $idProducto = $this->request->get("producto") ?? "";
            $data = $this->service->procesarPaso($paso, $idProducto, $data);
            if ($data["fin"] != "SI") {
                $this->pageFinderService->findFileRute("armar.tu.pc", "twig", "twig", [],
                    $data, $titulo, []);
                return;
            }
        }
        $this->session->put("procesado", "SI");
        $carritoController = new CarritoController();
        $carritoController->setSession($this->session);
        $carritoController->setConnection($this->connection);
        $carritoController->setLogger($this->logger);
        $carritoController->setRequest($this->request);
        $carritoController->init();
        $carritoController->mostrarTemplate();
    }
}