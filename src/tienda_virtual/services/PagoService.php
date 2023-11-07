<?php

namespace src\tienda_virtual\services;

use Exception;
use MercadoPago\Item;
use MercadoPago\Preference;
use src\tienda_virtual\database\models\products\ProductoModel;
use src\tienda_virtual\database\models\products\PublicacionModel;

class PagoService
{
    protected $preference;
    private $url = "https://65fb-191-80-87-72.ngrok-free.app";

    public function __construct()
    {
        $this->preference = new Preference();
        $this->preference->items = array();
    }

    /**
     * @throws Exception
     */
    public function addItem(PublicacionModel $publicacionModel, ProductoModel $productoModel) : void {
        MercadoPago\SDK::setAccessToken($config->get("APP_USR-8709825494258279-092911-227a84b3ec8d8b30fff364888abeb67a-1160706432"));
        MercadoPago\SDK::setIntegratorId($config->get("dev_24c65fb163bf11ea96500242ac130004"));
        $preference = new MercadoPago\Preference();

        //Se agregan los productos al mensaje que se le manda a la API de mercado pago
        $item = new MercadoPago\Item();
        $item->title = $data->description;
        $item->quantity = $data->quantity;
        $item->unit_price = $data->price;

        $preference->items = array($item);

        //Configuración, dónde se indicás a dónde querés que te avise mercado pago sobre el estado del pago
        $preference->back_urls = array(
            "success" => $url + "/success",//Si aprueba el pago
            "failure" => $url + "/failure",//Si se rechaza
            "pending" => $url + "/pending"//Si queda pendiente
        );
        $preference->auto_return = "approved"; 
        //Guardás para que te genere un ID en el servidor de Mercado Pago
        $preference->save();
        /*
        $item = new Item();
        $item->title = $productoModel->getField("descripcion");
        $item->quantity = 1;
        $item->unit_price = $publicacionModel->getField("precio_unidad");
        $this->preference->item[] = $item;
        $this->preference->back_urls = array(
            "success" => $url + "/success",
            "failure" => $url + "/failure",
            "pending" => $url + "/pending"
        );
        $this->preference->save();*/
    }

    public function getPreference(): Preference
    {
        return $this->preference;
    }
}