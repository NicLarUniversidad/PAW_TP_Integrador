<?php
namespace src\tienda_virtual\controllers\backoffice\categories;

use Exception;
use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\categories\GrupoCategoriaService;
use src\tienda_virtual\services\TwigPageFinderService;

class GrupoCategoriaController extends Controller
{
    private GrupoCategoriaService $service;

    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        parent::init();
        $this->service = new GrupoCategoriaService($this->connection, $this->logger);
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
    }

    public function get() : void
    {
        $cssImports = Array();
        $jsImports = Array();
        $data = $this->service->attachData();
        $this->pageFinderService->findFileRute("backoffice.abm","twig","twig", $cssImports,
            $data,"ABM Sub Categorías", $jsImports);
    }

    public function post(String $notification = null) : void
    {
        var_dump($_REQUEST);
        $cssImports = Array();
        $jsImports = Array();
        $data = $this->service->attachInsertData();
        $data["notification"] = $notification ?? "";
        if (!is_null($this->request->get("id"))) {
            //update
            $data["register"]["title"] = "Modificar Grupo de Categorías";
        }
        $data["tuple"] = $this->service->completeFormValues($this->request->get("id"), $this->request);
        $this->pageFinderService->findFileRute("backoffice.abm.alta","twig","twig", $cssImports,
            $data,"ABM Sub Categorías", $jsImports);
    }

    public function put() : void
    {
        //try {
            //TODO: Validaciones
            if (! is_null($this->request->get("abm-id"))) {
                //update
                $this->service->updateByDefaultABMForm($this->request);
            } else {
                //insert
                $this->service->saveByDefaultABMForm($this->request);
            }
            $this->get();
        //} catch (Exception $exception) {
            //$this->post("Ocurrió un error interno, contactar con un administrador.");
        //}
    }

    public function delete() {
        if (!is_null($this->request->get("id"))) {
            $this->service->deleteById($this->request->get("id"));
        } else {
            echo "...";
        }
        $this->get();
    }
}