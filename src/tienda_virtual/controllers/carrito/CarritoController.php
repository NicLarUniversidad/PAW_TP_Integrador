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
            //Se pasa URL para que después de logear se pueda redireccionar de nuevo aquí
            header("Location: login?redirect%=$url");
        }
        else {
            // $preference = new MercadoPago\Preference();
    
            // //Se agregan los productos al mensaje que se le manda a la API de mercado pago
            // $item = new MercadoPago\Item();
            // $item->title = $data->description;
            // $item->quantity = $data->quantity;
            // $item->unit_price = $data->price;
    
            // $preference->items = array($item);
    
            // //Configuración, dónde se indicás a dónde querés que te avise mercado pago sobre el estado del pago
            // $preference->back_urls = array(
            //     "success" => $url + "/success",//Si aprueba el pago
            //     "failure" => $url + "/failure",//Si se rechaza
            //     "pending" => $url + "/pending"//Si queda pendiente
            // );
            // $preference->auto_return = "approved"; 
            // //Guardás para que te genere un ID en el servidor de Mercado Pago
            // $preference->save();
            $cssImports = [];
            $cssImports[] = "main";
            $cssImports[] = "carrito";
            $jsImports = [];
            $jsImports[]="paw";
            $jsImports[]="app";
            if (!is_null($publicationId)) {
                //$this->carritoService->addItem($publicationId);
            }
            $data = $this->carritoService->findItems($data);
            //$this->preference->save();
            $data["preference"] = $preference ?? [];
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

    /**
     * @throws Exception
     */
    public function pagar(String $notificacion = "", array $data = [], String $titulo = "Carrito") {
        $idCarrito = $this->session->get("carrito");
        $data["preference"] = $this->carritoService->getPreference();
        $cssImports = [];
        $cssImports[] = "main";
        $cssImports[] = "carrito";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $this->pageFinderService->findFileRute("pagar","twig","twig", $cssImports,
            $data,$titulo, $jsImports);
    }

    /**
     * @throws Exception
     */
    public function addItem() {
        $publicationId = $this->request->get("publicationId");
        $this->logger->info("Id publicacion: " . $publicationId);
        $this->carritoService->addItem($publicationId);
    }

    /**
     * @throws Exception
     */
    public function deleteItem() {
        $publicationId = $this->request->get("publicationId");
        $this->logger->info("Id publicacion: " . $publicationId);
        $this->carritoService->deleteItem($publicationId);
    }
}