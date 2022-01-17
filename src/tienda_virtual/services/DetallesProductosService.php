<?php


namespace src\tienda_virtual\services;


use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\database\services\categories\ArmarPCFlujoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TSession;
use src\tienda_virtual\database\repositories\categories\DetalleProductoRepository;
use PDO;
use Monolog\Logger;

class DetallesProductosService
{
    use TConnection;
    use TLogger;
    use TSession;

    protected DetalleProductoRepository $DetallesProductosRepository;

     public function __construct(PDO $pdo, Logger $logger)
        {
            $this->setConnection($pdo);
            $this->setLogger($logger);
            $this->DetallesProductosRepository = new DetalleProductoRepository($logger, $pdo);
        }


    public function RecuperarDetalles (){
     return $this->DetallesProductosRepository->findAll();
    }

}