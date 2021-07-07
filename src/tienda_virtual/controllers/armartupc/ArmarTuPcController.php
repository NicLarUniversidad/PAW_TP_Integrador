<?php


namespace src\tienda_virtual\controllers\armartupc;


use src\tienda_virtual\database\services\categories\ArmarPCFlujoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\services\TwigPageFinderService;

class ArmarTuPcController extends \src\tienda_virtual\controllers\Controller
{
    protected ArmarPCFlujoService $flujoService;
    protected ProductoService $productoService;
    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->flujoService = new ArmarPCFlujoService($this->connection, $this->logger);
        $this->productoService = new ProductoService($this->connection, $this->logger);
    }
    public function mostrarTemplate(String $notificacion = "", array $data = [], String $titulo = "Armá tu PC") {
        $paso = $this->request->get("paso");
        $pasos = $this->flujoService->findAll();
        if (!isset($paso) && (count($pasos) > 0)) {
            $paso = $pasos[0]["id"];
        }
        $actual = null;
        if (isset($paso)) {
            $actual = $this->flujoService->find($paso)[0];
            $productos = $this->productoService->findBySubCategoriaId($actual["id_sub_categoria"]);
            if (count($productos) > 0) {
                $data["productos"] = $productos[0];
            } else {
                $data["productos"] = [];
            }

        }
        $data["actual"] = $actual;
        $data["pasos"] = $pasos;
        $this->pageFinderService->findFileRute("armar.tu.pc","twig","twig", [],
            $data,$titulo, []);
    }
}