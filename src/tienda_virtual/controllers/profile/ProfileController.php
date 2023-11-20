<?php

namespace src\tienda_virtual\controllers\profile;

use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\profile\ProfileService;
use src\tienda_virtual\services\TwigPageFinderService;

class ProfileController extends Controller
{

    private ProfileService $profileService;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->profileService = new ProfileService($this->connection, $this->logger);
    }

    public function isAuthorizedUser($method) : bool {
        return $this->isLoggedUser();
    }

    public function detailsView() {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data = [];
        $this->pageFinderService->findFileRute("perfil-detalles","twig","twig", $cssImports,
            $data, "Perfil", $jsImports);
    }

    public function addressView() {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data = [];
        $this->pageFinderService->findFileRute("perfil-direcciones","twig","twig", $cssImports,
            $data, "Direcciones", $jsImports);
    }
}