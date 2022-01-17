<?php


namespace src\tienda_virtual\controllers\detalleProducto;


use Exception;
use MercadoPago\Preference;
use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\services\TwigPageFinderService;
use src\tienda_virtual\services\DetallesProductosService;

class DetalleProductoController extends Controller
{
    protected DetallesProductosService $detallesService;
    protected Preference $preference;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->detallesService = new DetallesProductosService($this->connection, $this->logger);
        //$this->preference = new Preference();
    }

    /**
     * @throws Exception
     */
    public function mostrarDetalles(String $notificacion = "", array $data = [], String $titulo = "Carrito") {
        $cssImports = [];
        $cssImports[] = "main";
        $cssImports[] = "carrito";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data = ["detalleproducto"=>$this->detallesService->RecuperarDetalles ()];
        //$this->preference->save();
        $data["preference"] = $this->preference ?? [];
        $this->pageFinderService->findFileRute("detalle.producto","twig","twig", $cssImports,
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