<?php


namespace src\tienda_virtual\controllers\categoria;


use Exception;
use MercadoPago\Preference;
use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\services\TwigPageFinderService;
use src\tienda_virtual\services\CategoriasService;

class CategoriaController extends Controller
{
    protected CategoriasService $categoriaService;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->categoriaService = new CategoriasService($this->connection, $this->logger);
    }

    /**
     * @throws Exception
     */
    public function mostrarCategorias(String $notificacion = "", array $data = [], String $titulo = "Categorías") {
        $cssImports = [];
        $cssImports[] = "main";
        $cssImports[] = "carrito";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $grupoId = $this->request->get("grupo_categoria");
        $data["categorias"]= $this->categoriaService->RecuperarCategorias($grupoId);
        $this->pageFinderService->findFileRute("categorias","twig","twig", $cssImports,
            $data,$titulo, $jsImports);
    }

    /**
     * @throws Exception
     */
    public function cancelar(String $notificacion = "", array $data = [], String $titulo = "Categorías") {
        $this->session->delete("procesado");
        $idCarrito = $this->session->get("carrito");
        $this->carritoService->setInactice($idCarrito);
        $this->session->delete("carrito");
        $this->mostrarTemplate($notificacion, $data, $titulo);
    }
}