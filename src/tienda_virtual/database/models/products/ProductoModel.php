<?php


namespace src\tienda_virtual\database\models\products;


use src\tienda_virtual\database\models\Model;

class ProductoModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("descripcion", "");
        $this->setField("activo", "");
        $this->setField("precio_tentativo", "");
        $this->setField("id_moneda", "");
    }
}