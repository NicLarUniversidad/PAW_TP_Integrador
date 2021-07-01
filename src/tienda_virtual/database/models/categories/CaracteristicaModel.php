<?php


namespace src\tienda_virtual\database\models\categories;


class CaracteristicaModel extends \src\tienda_virtual\database\models\Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("descripcion", "");
        $this->setField("activo", "");
    }
}