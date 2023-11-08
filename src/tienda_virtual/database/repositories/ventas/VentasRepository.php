<?php

namespace src\tienda_virtual\database\repositories\ventas;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class VentasRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "venta", "ventas\\VentaModel");
    }
}