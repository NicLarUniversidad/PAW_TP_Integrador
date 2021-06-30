<?php

namespace src\tienda_virtual\database\services\repositories\categories;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\repositories\Repository;

class GrupoCategoriaRepository extends Repository
{

    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "grupo_categoria", "GrupoCategoriaModel");
    }
}