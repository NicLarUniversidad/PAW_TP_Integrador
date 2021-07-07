<?php


namespace src\tienda_virtual\database\models\carrito;


use src\tienda_virtual\database\models\Model;

class CarritoModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("precio_total", "");
        $this->setField("id_usuario", "");
        $this->setField("id_moneda", "");
        $this->setField("activo", "");
    }
}