<?php


namespace src\tienda_virtual\database\models\products;


use src\tienda_virtual\database\models\Model;

class FotografiaProductoModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("id_producto", "");
        $this->setField("url", "");
        $this->setField("activo", "");
    }
}