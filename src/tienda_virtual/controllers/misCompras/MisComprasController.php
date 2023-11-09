<?php

namespace src\tienda_virtual\controllers\misCompras;

use Exception;
use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\services\MisComprasService;
use src\tienda_virtual\services\TwigPageFinderService;

class MisComprasController extends Controller
{
    protected MisComprasService $miscomprasService;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->miscomprasService = new MisComprasService($this->connection, $this->logger);
        $this->miscomprasService->setSession($this->session);
    }

    /**
     * @throws Exception
     */
    public function mostrarMisCompras(String $notificacion = "", array $data = [], String $titulo = "Carrito") {
        $cssImports = [];
        $cssImports[] = "main";
        $cssImports[] = "carrito";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data["compras"] = $this->miscomprasService->getUserPurchases();
        $this->pageFinderService->findFileRute("mis-compras","twig","twig", $cssImports,
            $data,$titulo, $jsImports);
    }

    /**
     * @throws Exception
     */
    public function cancelar(String $notificacion = "", array $data = [], String $titulo = "Carrito") {
        $this->session->delete("procesado");
        $idCarrito = $this->session->get("carrito");
        $this->carritoService->setInactice($idCarrito);
        $this->session->delete("carrito");
    }
}