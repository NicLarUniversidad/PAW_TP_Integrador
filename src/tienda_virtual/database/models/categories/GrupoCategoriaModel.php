<?php

namespace src\tienda_virtual\database\models\categories;

use src\tienda_virtual\database\models\Model;

class GrupoCategoriaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("descripcion", "");
        $this->setField("activo", "");
    }
}