<?php


namespace src\tienda_virtual\controllers\carrito;


use Exception;
use MercadoPago\Preference;
use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\services\TwigPageFinderService;
use src\tienda_virtual\services\UserService;

class CarritoController extends Controller
{
    protected CarritoService $carritoService;
    protected Preference $preference;
    protected UserService $userService;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->carritoService = new CarritoService($this->connection, $this->logger);
        $this->carritoService->setSession($this->session);
        $this->carritoService->init();
        $this->userService = new UserService($this->connection, $this->logger);
        //$this->preference = new Preference();
    }

    /**
     * @throws Exception
     */
    public function mostrarTemplate(String $notificacion = "", array $data = [], String $titulo = "Carrito") {
        $loggedUser = $this->userService->getLoggedUser();
        $publicationId = $this->request->get("publicacion_id");
        if (is_null($loggedUser)) {
            $url = "login?redirect=carrito";
            if (!is_null($publicationId)) {
                //Hay que usar encoding para caracteres especiales en URL...
                //? %3F
                //= %3D
                $url .= "%3Fpublicacion_id%3D".$publicationId;
            }
            header("Location: login?redirect%=$url");
        }
        else {
            $cssImports = [];
            $cssImports[] = "main";
            $cssImports[] = "carrito";
            $jsImports = [];
            $jsImports[]="paw";
            $jsImports[]="app";
            $data = $this->carritoService->findItems($data);
            $this->carritoService->addItem($publicationId);
            //$this->preference->save();
            $data["preference"] = $this->preference ?? [];
            $this->pageFinderService->findFileRute("carrito","twig","twig", $cssImports,
                $data,$titulo, $jsImports);
        }
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