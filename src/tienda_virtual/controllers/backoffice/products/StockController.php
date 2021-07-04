<?php


namespace src\tienda_virtual\controllers\backoffice\products;


use src\tienda_virtual\controllers\backoffice\ABMController;

class StockController extends ABMController
{
    public function __construct()
    {
        parent::__construct("products\\StockService", "backoffice.abm");
    }
}