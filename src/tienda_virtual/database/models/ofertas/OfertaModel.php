<?php
namespace src\tienda_virtual\database\models\ofertas;

use src\tienda_virtual\database\models\Model;

class OfertaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setField("precio_oferta", "");
        $this->setField("activa", "");
        $this->setField("id_publicacion", "");
    }
}

