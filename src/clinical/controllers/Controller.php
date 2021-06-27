<?php


namespace src\tienda_virtual\controllers;


use src\tienda_virtual\services\PageFinderService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TRequest;
use src\tienda_virtual\traits\TSession;

class Controller
{
    use TSession;
    use TRequest;
    use TLogger;
    use TConnection;

    public PageFinderService $pageFinderService;

    public function __construct()
    {
        $this->pageFinderService = new PageFinderService();
    }

    public function init() {
        $this->pageFinderService->setSession($this->session);
    }
}