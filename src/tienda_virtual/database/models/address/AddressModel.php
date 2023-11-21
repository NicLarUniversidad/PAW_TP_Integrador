<?php

namespace src\tienda_virtual\database\models\address;

use src\tienda_virtual\database\models\Model;

class AddressModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("id", "");
        $this->setField("provincia", "");
        $this->setField("ciudad", "");
        $this->setField("calle", "");
        $this->setField("numero", "");
        $this->setField("medio", "");
        $this->setField("piso", "");
        $this->setField("departamento", "");
        $this->setField("codigo_postal", "");
        $this->setField("activo", "");
    }
}