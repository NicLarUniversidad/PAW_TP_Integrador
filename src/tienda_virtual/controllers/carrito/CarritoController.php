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
        $data = $this->carritoService->findItems($data);
        //$this->preference->save();
        $data["preference"] = $this->preference ?? [];
        $this->pageFinderService->findFileRute("carrito","twig","twig", [],
            $data,$titulo, []);
    }
}