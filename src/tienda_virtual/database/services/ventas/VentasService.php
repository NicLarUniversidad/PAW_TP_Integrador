<?php

namespace src\tienda_virtual\database\services\ventas;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\carrito\CarritoModel;
use src\tienda_virtual\database\services\DatabaseService;

class VentasService extends DatabaseService
{
    protected DetalleVentaService $detalleVentaService;
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "ventas\\VentasRepository");
        $this->detalleVentaService = new DetalleVentaService($PDO, $logger);
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
        $newSale->setField("monto", "0.00");
        $this->repository->save($newSale);
        foreach ($items as $item) {
            $this->detalleVentaService->createAndSaveSaleItem($item, $newSale->getField("id"));
        }
    }
}