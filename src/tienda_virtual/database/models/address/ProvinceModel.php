<?php

namespace src\tienda_virtual\database\models\address;

use src\tienda_virtual\database\models\Model;

class ProvinceModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("id", "");
        $this->setField("nombre", "");
    }
}