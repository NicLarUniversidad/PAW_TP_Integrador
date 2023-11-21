<?php

namespace src\tienda_virtual\database\models\address;

use src\tienda_virtual\database\models\Model;

class UserAddressModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("id", "");
        $this->setField("id_usuario", "");
        $this->setField("id_direccion", "");
    }
}