<?php


namespace src\tienda_virtual\database\models\products;


use src\tienda_virtual\database\models\Model;

class StockModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("fecha_entrada", "");
        $this->setField("cantidad_inicial", "");
        $this->setField("costo_unidad", "");
        $this->setField("id_producto", "");
        $this->setField("id_moneda", "");
    }
}