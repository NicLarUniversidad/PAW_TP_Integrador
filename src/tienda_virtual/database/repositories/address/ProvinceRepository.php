<?php

namespace src\tienda_virtual\database\repositories\address;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class ProvinceRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "provincia", "address\\ProvinceModel");
    }
}