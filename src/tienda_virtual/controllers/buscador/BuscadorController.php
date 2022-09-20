<?php

namespace src\tienda_virtual\controllers\buscador;

use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\services\TwigPageFinderService;

class BuscadorController extends Controller
{
    protected PublicacionService $publicacionService;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->publicacionService = new PublicacionService($this->connection, $this->logger);
    }

    public function buscar() : void
    {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="app";
        $jsImports[]="paw";
        $publicaciones = $this->publicacionService->buscar($this->request->get("buscador") ?? "");
        $data = ["publicaciones" => $publicaciones];
        $this->logger->info("DATA  " . json_encode($data));
        echo json_encode($data);
        /*$this->pageFinderService->findFileRute("buscador","twig","twig", $cssImports,
            $data,"ABM Sub Categorías", $jsImports);*/
    }
}