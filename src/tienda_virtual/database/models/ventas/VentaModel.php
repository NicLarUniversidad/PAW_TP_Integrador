<?php

namespace src\tienda_virtual\database\models\ventas;

use src\tienda_virtual\database\models\Model;
//"src\tienda_virtual\database\models\ventas\VentasModel"
class VentaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("id_carrito", "");
        $this->setField("id_usuario", "");
        $this->setField("estado", "");
        $this->setField("monto", "");
        $this->setField("fechaPago", "");
        $this->setField("activo", "");
    }
}