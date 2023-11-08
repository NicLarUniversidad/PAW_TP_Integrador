<?php

namespace src\tienda_virtual\database\repositories\ventas;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class SolicitudVentaRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "solicitud-venta", "ventas\\SolicitudVentaModel");
    }

    public function findPendingPaymentByExternalId($paymentId) {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["idPago" => $paymentId, "activo" => "SI", "estado" => "PENDIENTE"])
            ->execute();
    }
}