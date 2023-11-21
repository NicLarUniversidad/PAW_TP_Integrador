<?php

namespace src\tienda_virtual\database\services\address;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;
use src\tienda_virtual\exceptions\InvalidOperationException;
use src\tienda_virtual\exceptions\NotFoundException;
use src\tienda_virtual\services\UserService;
use src\tienda_virtual\traits\TSession;

class AddressService extends DatabaseService
{
    use TSession;
    private ProvinceService $provinceService;
    private LocationService $locationService;
    private UserAddressService $userAddressService;
    private UserService $userService;

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "address\\AddressRepository");
        $this->provinceService = new ProvinceService($PDO, $logger);
        $this->locationService = new LocationService($PDO, $logger);
        $this->userAddressService = new UserAddressService($PDO, $logger);
        $this->userService = new UserService($PDO, $logger);
    }

    public function getAllProvinces() : array {
        return $this->provinceService->findAll();
    }

    public function getLocationByProvinceId($provinceId) : array {
        return $this->locationService->findByProvince($provinceId);
    }

    public function validateProvince($province): bool
    {
        $provinceList = $this->provinceService->find($province);
        return count($provinceList) > 0;
    }

    public function validateLocality($city)
    {
        $localityList = $this->locationService->find($city);
        return count($localityList) > 0;
    }

    public function addAddress($zipCode, $province, $city, $street, $streetNumber, $departmentNumber)
    {
        $provinceData = $this->provinceService->find($province)[0];
        $locationData = $this->locationService->find($city)[0];
        $userData = $this->session->get(UserService::$USER_SESSION_NAME);
        $address = $this->repository->addAddress($zipCode, $provinceData["id"], $locationData["id"], $street, $streetNumber,
            $departmentNumber);
        $this->userAddressService->add($address["id"], $userData["id"]);
    }

    public function getUserAddresses() : array
    {
        $user = $this->session->get(UserService::$USER_SESSION_NAME);
        $userAddresses = $this->userAddressService->findByUserId($user["id"]);
        $addresses = [];
        foreach ($userAddresses as $userAddress) {
            $address = $this->repository->find($userAddress["id_direccion"])[0];
            $address["nombreProvincia"] = $this->provinceService->find($address["provincia"])[0]["nombre"];
            $address["nombreCiudad"] = $this->locationService->find($address["ciudad"])[0]["nombre"];
            $userModel = $this->userService->find($user["id"]);
            $this->logger->info("Direccion " . $userAddress["id"] . " usuario: " . json_encode($userModel));
            if ($userAddress["id"] == $userModel["id_direccion_default"]) {
                $address["default"] = "SI";
            }
            else {
                $address["default"] = "NO";
            }
            $addresses[] = $address;
        }
        return $addresses;
    }

    /**
     * @throws NotFoundException
     * @throws InvalidOperationException
     */
    public function setDefaultAddress($idAddress)
    {
        $this->logger->info("Se busca la dirección con id " . $idAddress);
        $addresses = $this->repository->find($idAddress);
        $user = $this->session->get(UserService::$USER_SESSION_NAME);
        $userAddress = $this->userAddressService->findByUserAndAddress($user["id"], $addresses[0]["id"])[0];
        if (empty($addresses)) {
            $message = "ERROR no se encontró la dirección con id " . $idAddress;
            $this->logger->warning($message);
            throw new NotFoundException($message);
        }
        else {
            $this->logger->info(json_encode($userAddress));
            if ($userAddress["id_usuario"] != $user["id"]) {
                $this->logger->info("b");
                $message = "ERROR se intentó asignar la dirección con id " . $idAddress .
                    " al usuario id " . $user["id"] . " cuando es una dirección del usuario " . $addresses[0]["id_usuario"];
                $this->logger->warning($message);
                throw new InvalidOperationException($message);
            }
            else {
                $this->userService->setDefaultAddress($user, $userAddress["id"]);
            }
        }
    }
}