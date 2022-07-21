<?php

namespace src\tienda_virtual\controllers\misCompras;

use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\services\MisComprasService;

class MisComprasController extends Controller
{
    protected MisComprasService $miscomprasService;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->miscomprasService = new MisComprasService($this->connection, $this->logger);
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
        $idpublicacion=$this->request->get("publicacion");
        $data["publicacion"] = $this->publicacion -> find($idpublicacion) ?? [];
        $data["preference"] = $this->preference ?? [];
        $this->pageFinderService->findFileRute("miscompras","twig","twig", $cssImports,
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