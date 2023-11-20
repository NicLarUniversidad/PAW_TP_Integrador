<?php

namespace src\tienda_virtual\database\services\address;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class LocationService extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "address\\LocationRepository");
    }

    public function findByProvince($provinceId) : array
    {
        return $this->repository->findByProvince($provinceId);
    }
}