<?php

namespace src\tienda_virtual\database\services\carrito;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\services\DatabaseService;

class ItemCarritoService extends DatabaseService
{

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "carrito\\ItemCarritoRepository");
    }

    public function findByCarritoId(string $carrito) : array
    {
        $this->repository->findByCarritoId($carrito);
    }

    public function create($id_carrito, string $id_publicacion, String $precioUnidad, String $moneda, String $cantidad = "1") : Model
    {
        $item = $this->repository->createInstance();
        $item->setField("id_carrito", $id_carrito);
        $item->setField("id_publicacion", $id_publicacion);
        $item->setField("precio_unidad", $precioUnidad);
        $item->setField("moneda", $moneda);
        $item->setField("cantidad", $cantidad);
        $item->setField("activo", "SI");
        return $item;
    }
}