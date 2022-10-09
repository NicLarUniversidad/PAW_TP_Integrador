<?php


namespace src\tienda_virtual\database\models\products;


use src\tienda_virtual\database\models\Model;

class PublicacionModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        /*$this->setField("fecha_entrada", "");*/
        $this->setField("cantidad_inicial", "");
        $this->setField("id_producto", "");
        $this->setField("precio_unidad", "");
        $this->setField("id_moneda", "");
    }
}