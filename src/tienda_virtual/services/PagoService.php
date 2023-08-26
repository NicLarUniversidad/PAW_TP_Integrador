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

    public function __construct()
    {
        $this->preference = new Preference();
        $this->preference->items = array();
    }

    /**
     * @throws Exception
     */
    public function addItem(PublicacionModel $publicacionModel, ProductoModel $productoModel) : void {
        $item = new Item();
        $item->title = $productoModel->getField("descripcion");
        $item->quantity = 1;
        $item->unit_price = $publicacionModel->getField("precio_unidad");
        $this->preference->item[] = $item;
        $this->preference->save();
    }

    public function getPreference(): Preference
    {
        return $this->preference;
    }
}