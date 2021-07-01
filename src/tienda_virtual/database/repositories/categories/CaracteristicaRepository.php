<?php


namespace src\tienda_virtual\database\repositories\categories;


use Monolog\Logger;
use PDO;

class CaracteristicaRepository extends \src\tienda_virtual\database\repositories\Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "caracteristica", "categories\\CaracteristicaModel");
    }
}