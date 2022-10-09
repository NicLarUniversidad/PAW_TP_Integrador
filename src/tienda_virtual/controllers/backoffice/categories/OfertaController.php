<?php

namespace src\tienda_virtual\controllers\backoffice\categories;

use src\tienda_virtual\controllers\backoffice\ABMController;

class OfertaController extends ABMController
{
    public function __construct()
    {
        parent::__construct("categories\\OfertaService", "backoffice.abm");
    }
}