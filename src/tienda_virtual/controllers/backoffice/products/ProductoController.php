<?php


namespace src\tienda_virtual\controllers\backoffice\products;


use src\tienda_virtual\controllers\backoffice\ABMController;

class ProductoController extends ABMController
{
    public function __construct()
    {
        parent::__construct("products\\ProductoService", "backoffice.abm");
    }
}