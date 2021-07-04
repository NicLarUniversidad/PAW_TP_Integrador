<?php


namespace src\tienda_virtual\database\repositories\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class ProductoSubCategoriaRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "producto_sub_categoria", "products\\ProductoSubCategoriaModel");
    }
}