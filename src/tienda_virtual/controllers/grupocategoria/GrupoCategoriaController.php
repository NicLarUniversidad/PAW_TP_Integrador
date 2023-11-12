<?php


namespace src\tienda_virtual\controllers\grupocategoria;


use Exception;
use MercadoPago\Preference;
use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\services\TwigPageFinderService;
use src\tienda_virtual\services\GrupoCategoriasService;

class GrupoCategoriaController extends Controller
{
    protected GrupoCategoriasService $grupocategoriaService;
    protected Preference $preference;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->grupocategoriaService = new GrupoCategoriasService($this->connection, $this->logger);
    }

    /**
     * @throws Exception
     */
    public function mostrarGrupoCategorias(String $notificacion = "", array $data = [], String $titulo = "Categorías") {
        $cssImports = [];
        $cssImports[] = "main";
        $cssImports[] = "carrito";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data["grupo_categorias"] = $this->grupocategoriaService->RecuperarGrupoCategorias();
        $data["preference"] = $this->preference ?? [];
        $this->pageFinderService->findFileRute("grupo_categorias","twig","twig", $cssImports,
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