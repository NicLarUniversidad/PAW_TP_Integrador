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
        $publicaciones = $this->publicacionService->buscar($this->request->get("buscar") ?? "");
        $data = ["publicaciones" => $publicaciones];
        $this->pageFinderService->findFileRute("buscador","twig","twig", [],
            $data,"ABM Sub Categorías", []);
    }
}