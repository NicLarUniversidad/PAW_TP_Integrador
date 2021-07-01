<?php

namespace src\tienda_virtual\controllers\backoffice;

use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\DatabaseService;
use src\tienda_virtual\services\TwigPageFinderService;

class ABMController extends Controller
{
    private DatabaseService $service;
    private String $serviceName;
    private String $url;

    public function __construct(String $databaseServiceName, String $url)
    {
        parent::__construct();
        $this->serviceName = "src\\tienda_virtual\\database\\services\\categories\\".$databaseServiceName;
        $this->url = $url;
    }

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->service = new $this->serviceName($this->connection, $this->logger);
    }

    public function get(array $cssImports = [], array $jsImports = []) : void
    {
        $data = $this->service->attachData();
        $this->pageFinderService->findFileRute($this->url,"twig","twig", $cssImports,
            $data,"ABM Sub Categorías", $jsImports);
    }

    public function post(String $notification = null, array $cssImports = [], array $jsImports = [], String $title = "Tienda virtual") : void
    {
        $data = $this->service->attachInsertData();
        $data["notification"] = $notification ?? "";
        if (!is_null($this->request->get("id"))) {
            //update
            $data["register"]["title"] = $title;
        }
        $data["tuple"] = $this->service->completeFormValues($this->request->get("id"), $this->request);
        $this->pageFinderService->findFileRute("$this->url.alta","twig","twig", $cssImports,
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