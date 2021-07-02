<?php


namespace src\tienda_virtual\controllers\backoffice\categories;


use src\tienda_virtual\controllers\backoffice\ABMController;

class ValorCaracteristicaController extends ABMController
{
    public function __construct()
    {
        parent::__construct("ValorCaracteristicaService", "backoffice.abm");
    }
}