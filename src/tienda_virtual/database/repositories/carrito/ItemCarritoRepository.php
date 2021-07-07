<?php

namespace src\tienda_virtual\database\repositories\carrito;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class ItemCarritoRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "item_carrito", "carrito\\ItemCarritoModel");
    }

    public function findByCarritoId(string $id_carrito): array
    {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_carrito"=>$id_carrito])
            ->execute();
    }
}