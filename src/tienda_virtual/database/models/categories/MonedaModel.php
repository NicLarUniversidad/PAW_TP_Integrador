<?php


namespace src\tienda_virtual\database\models\categories;


use src\tienda_virtual\database\models\Model;

class MonedaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("nombre", "");
        $this->setField("activo", "");
    }
}