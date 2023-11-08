<?php

namespace src\tienda_virtual\database\models\ventas;

use src\tienda_virtual\database\models\Model;

class SolicitudVentaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("id_carrito", "");
        $this->setField("idPago", "");
        $this->setField("estado", "");
        $this->setField("activo", "");
    }
}