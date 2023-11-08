<?php

namespace src\tienda_virtual\database\services\ventas;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class SolicitudVentaService extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "ventas\\SolicitudVentaRepository");
    }

    public function createpaymentRequest($idCarrito, $preferenceId)
    {
        $paymentRequest = $this->repository->createInstance();
        $paymentRequest->setField("id_carrito", $idCarrito);
        $paymentRequest->setField("idPago", $preferenceId);
        $paymentRequest->setField("estado", "PENDIENTE");
        $paymentRequest->setField("activo", "SI");
        $this->repository->save($paymentRequest);
    }

    public function findPendingPaymentByExternalId($paymentId) {
        return $this->repository->findPendingPaymentByExternalId($paymentId);
    }

    public function pay($paymentData)
    {
        $paymentRequest = $this->repository->createInstance();
        $paymentRequest->setFields($paymentData);
        $paymentRequest->setField("estado", "PAGADO");
        $this->repository->update($paymentRequest);
    }
}