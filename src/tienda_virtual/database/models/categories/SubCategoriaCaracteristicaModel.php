<?php


namespace src\tienda_virtual\database\models\categories;


use src\tienda_virtual\database\models\Model;

class SubCategoriaCaracteristicaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("activo", "");
        $this->setField("id_sub_categoria", "");
        $this->setField("id_caracteristica", "");
    }
}