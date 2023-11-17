<?php

namespace src\tienda_virtual\database\services\ventas;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\carrito\CarritoService;
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
        $newSale->setField("estado", "PENDIENTE_DE_ENVIO");
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
        $sales = $this->repository->getActivePurchases();
        return $this->fillPublications($sales);
    }

    public function getPendingPurchases()
    {
        $sales = $this->repository->getPurchasesByState("PENDIENTES_DE_ENVIO");
        return $this->fillPublications($sales);
    }

    public function getSentPurchases()
    {
        $sales =  $this->repository->getPurchasesByState("ENVIADO");
        return $this->fillPublications($sales);
    }

    public function getReceivedPurchases()
    {
        $sales =  $this->repository->getPurchasesByState("RECIBIDO");
        return $this->fillPublications($sales);
    }

    public function isValidState($idVenta, string $string) : bool
    {
        $this->logger->info("Validando estado de venta número: " . $idVenta);
        $isValid = false;
        $venta = $this->repository->find($idVenta);
        $this->logger->info("  Venta recuperada: " . serialize($venta));
        if (isset($venta)) {
            switch ($string) {
                case "ENVIADO":
                    $isValid = $venta[0]["estado"] == "PENDIENTE_DE_ENVIO";
                    break;
                case "RECIBIDO":
                    $isValid = $venta[0]["estado"] == "ENVIADO";
                    break;
                default:
                    //ignore
                    break;
            }
        }
        return $isValid;
    }

    public function sendPackage($idVenta)
    {
        $this->logger->info("  Cambiando estado de PENDIENTE_DE_ENVIO a ENVIADO");
        $this->changeSaleState($idVenta, "ENVIADO");
    }

    public function receivePackage($idVenta)
    {
        $this->logger->info("  Cambiando estado de ENVIADO a RECIBIDO");
        $this->changeSaleState($idVenta, "RECIBIDO");
    }

    private function changeSaleState($idVenta, $state) {
        $updatedSale = $this->repository->createInstance();
        $values = $this->repository->find($idVenta);
        $updatedSale->setFields($values[0]);
        $updatedSale->setField("estado", $state);
        $this->logger->info("  Haciendo update");
        $this->repository->update($updatedSale);
    }

    private function fillPublications(array $sales) : array {
        $result = [];
        foreach ($sales as $sale) {
            $result[] = $sale;
        }
        return $result;
    }
}