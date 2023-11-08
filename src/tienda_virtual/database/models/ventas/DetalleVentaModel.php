<?php

namespace src\tienda_virtual\database\models\ventas;

use src\tienda_virtual\database\models\Model;

class DetalleVentaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("id_venta", "");
        $this->setField("id_publicacion", "");
        $this->setField("monto", "");
        $this->setField("activo", "");
    }
}