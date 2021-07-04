<?php


namespace src\tienda_virtual\database\models\categories;


use src\tienda_virtual\database\models\Model;

class RestriccionModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("descripcion", "");
        $this->setField("activo", "");
        $this->setField("id_flujo", "");
        $this->setField("id_caracteristica", "");
        $this->setField("operador", "");
        $this->setField("constante", "");

    }
}