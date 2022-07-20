<?php

namespace src\tienda_virtual\database\models\misCompras;

use src\tienda_virtual\database\models\Model;

class compraImpagaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("fecha_inicio", "");
        $this->setField("cantidad", "");
        $this->setField("estado", "");
        $this->setField("id_carrito", "");
        $this->setField("activo", "");
    }
}