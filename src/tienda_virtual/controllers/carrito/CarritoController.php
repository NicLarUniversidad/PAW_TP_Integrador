<?php


namespace src\tienda_virtual\controllers\carrito;


use Exception;
use MercadoPago\Preference;
use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\services\TwigPageFinderService;

class CarritoController extends Controller
{
    protected CarritoService $carritoService;
    protected Preference $preference;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->carritoService = new CarritoService($this->connection, $this->logger);
        $this->carritoService->setSession($this->session);
        $this->carritoService->init();
        //$this->preference = new Preference();
    }

    /**
     * @throws Exception
     */
    public function mostrarTemplate(String $notificacion = "", array $data = [], String $titulo = "Carrito") {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="app";
        $jsImports[]="paw";
        $data = $this->carritoService->findItems($data);
        //$this->preference->save();
        $data["preference"] = $this->preference ?? [];
        $this->pageFinderService->findFileRute("carrito","twig","twig", $cssImports,
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
        $this->mostrarTemplate($notificacion, $data, $titulo);
    }
}