<?php


namespace src\tienda_virtual\database\repositories\categories;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class SubCategoriaCaracteristicaRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "sub_categoria_caracteristica", "categories\\SubCategoriaCaracteristicaModel");
    }
}