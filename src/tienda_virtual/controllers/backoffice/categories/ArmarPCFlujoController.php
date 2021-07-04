<?php

namespace src\tienda_virtual\controllers\backoffice\categories;

use src\tienda_virtual\controllers\backoffice\ABMController;
use src\tienda_virtual\database\services\DatabaseService;


class ArmarPCFlujoController extends ABMController

{
    public function __construct()
    {
        parent::__construct("categories\\ArmarPCFlujoService", "backoffice.abm");
    }
}