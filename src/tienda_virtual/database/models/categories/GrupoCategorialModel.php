<?php

namespace src\tienda_virtual\database\services\models\categories;

use src\tienda_virtual\database\models\Model;

class GrupoCategorialModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("descripcion", "");
        $this->setField("activo", "");
    }
}