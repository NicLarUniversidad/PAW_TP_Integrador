<?php

namespace src\tienda_virtual\database\repositories\ventas;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class DetalleVentaRepository  extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "detalleVenta", "ventas\\DetalleVentaModel");
    }

    public function findBySaleId($saleId)
    {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_venta"=>$saleId])
            ->execute();
    }
}