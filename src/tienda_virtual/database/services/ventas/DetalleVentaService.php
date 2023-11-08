<?php

namespace src\tienda_virtual\database\services\ventas;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class DetalleVentaService  extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "ventas\\DetalleVentaRepository");
    }

    public function createAndSaveSaleItem($item, $saleId)
    {
        $newSaleItem = $this->repository->createInstance();
        $newSaleItem->setField("id_venta", $saleId);
        $newSaleItem->setField("id_publicacion", $item["id_publicacion"]);
        $newSaleItem->setField("monto", $item["precio_unidad"]);
        $newSaleItem->setField("activo", "SI");
        $this->repository->save($newSaleItem);
    }

}