<?php

namespace src\tienda_virtual\controllers\profile;

use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\address\AddressService;
use src\tienda_virtual\database\services\profile\ProfileService;
use src\tienda_virtual\exceptions\InvalidOperationException;
use src\tienda_virtual\exceptions\NotFoundException;
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
        $this->addressService->setSession($this->session);
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

    public function addAddress() {
        $zipCode = $this->request->get("cod-postal");
        $province = $this->request->get("provincia");
        $city = $this->request->get("ciudad");
        $street = $this->request->get("calle");
        $streetNumber = $this->request->get("numero");
        $departmentNumber = $this->request->get("departamento");
        $validRequest = true;
        $error = "";

        //Validar campos obligatorios
        if (!isset($zipCode)) {
            $validRequest = false;
            $error = "No se ha ingresado código postal";
        }
        if (!isset($province)) {
            $validRequest = false;
            $error = "No se ha ingresado provincia";
        }
        if (!isset($city)) {
            $validRequest = false;
            $error = "No se ha ingresado ciudad";
        }
        if (!isset($street)) {
            $validRequest = false;
            $error = "No se ha ingresado calle";
        }
        if (!isset($streetNumber)) {
            $validRequest = false;
            $error = "No se ha ingresado número de calle";
        }

        //Validar datos provincia y localidad
        if (!$this->addressService->validateProvince($province)) {
            $validRequest = false;
            $error = "No se ha ingresado una provincia inválida";
        }
        if (!$this->addressService->validateLocality($city)) {
            $validRequest = false;
            $error = "No se ha ingresado una localidad inválida";
        }

        if ($validRequest) {
            $this->logger->info("OK");
            //Se agrega la nueva dirección
            $this->addressService->addAddress(
              $zipCode,
              $province,
              $city,
              $street,
              $streetNumber,
              $departmentNumber
            );
            echo "OK";
        }
        else {
            $this->logger->info("ERROR : " . $error);
            //Se manda un mensaje de error
            //TODO: Código HTTP
            //No me deja devolver el mensaje de error
            //http_response_code(403);
            echo $error;
        }
    }

    public function addressList() {
        $addresses = $this->addressService->getUserAddresses();
        echo json_encode($addresses);
    }

    public function postDefaultAddress() {
        $idAddress = $this->request->get("id_address");
        try {
            $this->addressService->setDefaultAddress($idAddress);
        } catch (NotFoundException $e) {
            //Devuelvo 404 porque no se encontró la dirección que se quiere asignar
            http_response_code(404);
        } catch (InvalidOperationException $e) {
            //Devuelvo 409 por conflictos con los datos
            http_response_code(409);
        }
    }
}