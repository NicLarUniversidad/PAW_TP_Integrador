<?php

namespace src\tienda_virtual\database\models\carrito;

use src\tienda_virtual\database\models\Model;

class ItemCarritoModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("precio_unidad", "");
        $this->setField("cantidad", "");
        $this->setField("id_publicacion", "");
        $this->setField("id_carrito", "");
        $this->setField("id_moneda", "");
        $this->setField("activo", "");
    }
}