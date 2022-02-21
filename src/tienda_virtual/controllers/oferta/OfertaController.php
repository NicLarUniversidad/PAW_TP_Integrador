<?php


namespace src\tienda_virtual\controllers\oferta;


use Exception;
use MercadoPago\Preference;
use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\services\TwigPageFinderService;
use src\tienda_virtual\services\OfertasService;

class OfertaController extends Controller
{
    protected OfertasService $ofertaService;
    protected Preference $preference;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->ofertaService = new OfertasService($this->connection, $this->logger);
        //$this->preference = new Preference();
    }

    /**
     * @throws Exception
     */
    public function mostrarOfertas(String $notificacion = "", array $data = [], String $titulo = "Carrito") {
        $cssImports = [];
        $cssImports[] = "main";
        $cssImports[] = "carrito";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data = ["ofertas"=>$this->ofertaService->RecuperarOfertas ()];
        //$this->preference->save();
        //var_dump($idPublicacion);
        //die;
        $data["preference"] = $this->preference ?? [];
        $this->pageFinderService->findFileRute("ofertas","twig","twig", $cssImports,
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