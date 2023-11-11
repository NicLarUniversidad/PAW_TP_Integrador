<?php

namespace src\tienda_virtual\database\services\ventas;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\carrito\CarritoModel;
use src\tienda_virtual\database\services\DatabaseService;
use src\tienda_virtual\database\services\products\PublicacionService;

class VentasService extends DatabaseService
{
    protected DetalleVentaService $detalleVentaService;
    protected PublicacionService $publicacionService;
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "ventas\\VentasRepository");
        $this->detalleVentaService = new DetalleVentaService($PDO, $logger);
        $this->publicacionService = new PublicacionService($PDO, $logger);
    }

    public function addSale($cart, $items)
    {
        $this->logger->info("Se efectúa la compra del carrito: " . serialize($cart));
        $newSale = $this->repository->createInstance();
        $newSale->setField("id_carrito", $cart["id"]);
        $newSale->setField("id_usuario", $cart["id_usuario"]);
        $newSale->setField("estado", "PENDIENTE_DE_ENVÍO");
        $newSale->setField("fechaPago", date('Y-m-d H:i:s'));
        $newSale->setField("activo", "SI");
        $monto = 0.0;
        foreach ($items as $item) {
            $monto += floatval($item["precio_unidad"]);
        }
        $newSale->setField("monto", $monto);
        $this->repository->save($newSale);
        foreach ($items as $item) {
            $this->detalleVentaService->createAndSaveSaleItem($item, $newSale->getField("id"));
        }
    }

    public function getUserPurchases($userId)
    {
        $this->logger->info("Buscando compras de usuario con id = " . $userId);
        return $this->repository->findByUser($userId);
    }

    public function findItemsBySaleId($saleId)
    {
        $ventas = $this->detalleVentaService->findBySaleId($saleId);
        $result = [];
        foreach ($ventas as $venta) {
            $venta["publicacion"] = $this->publicacionService->findWithData($venta["id_publicacion"]);
            $result[] = $venta;
        }
        return $result;
    }

    public function getActivePurchases() : array
    {
        return $this->repository->getActivePurchases();
    }

    public function getPendingPurchases()
    {
        return $this->repository->getPurchasesByState("PENDIENTES_DE_ENVIO");
    }

    public function getSentPurchases()
    {
        return $this->repository->getPurchasesByState("ENVIADO");
    }

    public function getReceivedPurchases()
    {
        return $this->repository->getPurchasesByState("RECIBIDO");
    }
}