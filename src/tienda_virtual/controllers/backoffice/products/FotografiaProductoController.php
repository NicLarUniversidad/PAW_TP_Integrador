<?php


namespace src\tienda_virtual\controllers\backoffice\products;


use src\tienda_virtual\controllers\backoffice\ABMController;
use src\tienda_virtual\database\services\products\FotografiaProductoService;
use src\tienda_virtual\services\FileService;

class FotografiaProductoController extends ABMController
{
    private FileService $fileService;
    public function __construct()
    {
        parent::__construct("products\\FotografiaProductoService", "backoffice.abm");
    }
}