<?php


namespace src\tienda_virtual\controllers\backoffice\categories;


use src\tienda_virtual\controllers\backoffice\ABMController;

class MonedaController extends ABMController
{
    public function __construct()
    {
        parent::__construct("categories\\MonedaService", "backoffice.abm");
    }
}