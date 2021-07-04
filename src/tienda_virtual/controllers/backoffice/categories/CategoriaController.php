<?php


namespace src\tienda_virtual\controllers\backoffice\categories;

use src\tienda_virtual\controllers\backoffice\ABMController;
use src\tienda_virtual\database\services\DatabaseService;

class CategoriaController extends ABMController
{
    public function __construct()
    {
        parent::__construct("categories\\CategoriaService", "backoffice.abm");
    }
}