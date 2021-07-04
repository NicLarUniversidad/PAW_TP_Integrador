<?php


namespace src\tienda_virtual\database\repositories\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class FotografiaProductoRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "fotografia_producto", "products\\FotografiaProductoModel");
    }

    public function findByProducto(array $producto) : array {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_producto"=>$producto["id"]])
            ->execute();
    }
}