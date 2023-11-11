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

    public function findByUser($userId) : array
    {
        $model = $this->getModelInstance();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_usuario"=> $userId])
            ->execute();
    }

    public function getActivePurchases(): array
    {
        $model = $this->getModelInstance();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["activo"=> "si"])
            ->execute();
    }

    public function getPurchasesByState($state): array
    {
        $model = $this->getModelInstance();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["estado"=> $state, "activo"=> "si"])
            ->execute();
    }
}