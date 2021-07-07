<?php

namespace src\tienda_virtual\database\services\carrito;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class ItemCarritoService extends DatabaseService
{

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "carrito\\ItemCarritoRepository");
    }

    public function findByCarritoId(string $carrito) : array
    {
        $this->repository->findByCarritoId($carrito);
    }
}