<?php


namespace src\tienda_virtual\controllers\armartupc;


use src\tienda_virtual\services\TwigPageFinderService;

class ArmarTuPcController extends \src\tienda_virtual\controllers\Controller
{

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
    }
    public function mostrarTemplate(String $notificacion = "", array $data = [], String $titulo = "Armá tu PC") {

        $this->pageFinderService->findFileRute("armar.tu.pc","twig","twig", [],
            $data,$titulo, []);
    }
}