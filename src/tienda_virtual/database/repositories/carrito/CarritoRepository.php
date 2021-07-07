<?php


namespace src\tienda_virtual\database\repositories\carrito;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class CarritoRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "carrito", "carrito\\CarritoModel");
    }
}