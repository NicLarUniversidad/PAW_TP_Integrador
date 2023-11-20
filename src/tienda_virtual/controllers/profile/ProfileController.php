<?php

namespace src\tienda_virtual\controllers\profile;

use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\address\AddressService;
use src\tienda_virtual\database\services\profile\ProfileService;
use src\tienda_virtual\services\TwigPageFinderService;

class ProfileController extends Controller
{

    private ProfileService $profileService;
    private AddressService $addressService;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->profileService = new ProfileService($this->connection, $this->logger);
        $this->addressService = new AddressService($this->connection, $this->logger);
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
        $data["provincias"] = $this->addressService->getAllProvinces();
        $this->pageFinderService->findFileRute("perfil-direcciones","twig","twig", $cssImports,
            $data, "Direcciones", $jsImports);
    }

    public function postGetLocations() {
        $provinceId = $this->request->get("provincia_id");
        if (isset($provinceId)) {
            $locations = $this->addressService->getLocationByProvinceId($provinceId);
            echo json_encode($locations);
        }
        else {
            echo "[]";
        }
    }
}