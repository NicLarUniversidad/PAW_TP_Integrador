<?php

namespace src\tienda_virtual\database\services\address;

use Monolog\Logger;
use PDO;

class AddressService {

    private ProvinceService $provinceService;
    private LocationService $locationService;

    public function __construct(PDO $PDO, Logger $logger)
    {
        $this->provinceService = new ProvinceService($PDO, $logger);
        $this->locationService = new LocationService($PDO, $logger);
    }

    public function getAllProvinces() : array {
        return $this->provinceService->findAll();
    }

    public function getLocationByProvinceId($provinceId) : array {
        return $this->locationService->findByProvince($provinceId);
    }
}