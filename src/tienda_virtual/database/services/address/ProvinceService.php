<?php

namespace src\tienda_virtual\database\services\address;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class ProvinceService extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "address\\ProvinceRepository");
    }
}