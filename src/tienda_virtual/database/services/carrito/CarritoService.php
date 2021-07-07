<?php

namespace src\tienda_virtual\database\services\carrito;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TSession;

class CarritoService extends DatabaseService
{
    use TSession;

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "carrito\\CarritoRepository");
    }

    public function init() {

    }

    public function findItems(array $data = [], String $carrito = "") : array
    {
        if ($carrito != "") {

        }
        return $data;
    }
}