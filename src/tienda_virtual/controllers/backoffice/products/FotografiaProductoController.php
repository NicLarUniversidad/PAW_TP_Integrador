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

    public function put() : void
    {
        $archivo = $_FILES['url'];
        $this->session->put("photograph_url", $archivo);
        if (! is_null($this->request->get("abm-id"))) {
            //update
            $this->service->updateByDefaultABMForm($this->request);
        } else {
            //insert
            $this->service->saveByABMForm($this->request, $archivo);
        }
        $this->get();
        $this->session->delete("photograph_url");
    }
}