<?php

namespace src\tienda_virtual\controllers;

use MercadoPago\Preference;
use MercadoPago\Item;
use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\services\TwigPageFinderService;
use src\tienda_virtual\services\UserService;

class MercadoPagoHandlerController extends Controller
{
    protected CarritoService $carritoService;
    protected UserService $userService;
    //private string $url = "http://localhost:12000";
    private string $url = "https://8184-149-102-233-227.ngrok-free.app";

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->carritoService = new CarritoService($this->connection, $this->logger);
        $this->carritoService->setSession($this->session);
        $this->carritoService->init();
        $this->userService = new UserService($this->connection, $this->logger);
    }

    public function post()
    {
        //obtengo items
        $data = $this->carritoService->findItems();

        $preference = new Preference();

        $items = [];
        //Se recorre cada item del carrito
        foreach ($data["publicaciones"] as $publicacion) {
            $item = new Item();
            //Se agrega el nombre del item
            $item->title = $publicacion["nombre"];
            //Cantidad
            $item->quantity = 1;
            //Precio
            $item->unit_price = 1;//$publicacion["precio_unidad"];
            $items[] = $item;
        }

        $preference->items = $items;

        $preference->back_urls = array(
            "success" => $this->url . "/success",
            "failure" => $this->url . "/failure",
            "pending" => $this->url . "/pending"
        );
        $preference->auto_return = "approved"; 

        $preference->save();

        $this->carritoService->registerPayment($preference->id);

        $response = array(
            'id' => $preference->id,
        ); 
        echo json_encode($response);
    }

    public function success() {
        //TODO: Pago completo, restar stock
        $id = $this->request->get("preference_id");
        $this->carritoService->pay($id);
        $cssImports = [];
        $cssImports[] = "main";
        $cssImports[] = "carrito";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $this->pageFinderService->findFileRute("pago-completo","twig","twig", $cssImports,
            [],"", $jsImports);
    }

    public function failure() {
        //TODO: Pago fallido
    }

    public function pending() {
        //TODO: Pago pendiente
    }
}