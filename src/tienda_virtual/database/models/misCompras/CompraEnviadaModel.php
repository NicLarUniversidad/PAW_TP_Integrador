<?php

namespace src\tienda_virtual\database\models\misCompras;

use src\tienda_virtual\database\models\Model;

class compraEnviadaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("fecha_pago", "");
        $this->setField("cantidad", "");
        $this->setField("estado", "");
        $this->setField("id_compra_pagada", "");
        $this->setField("activo", "");
    }
}