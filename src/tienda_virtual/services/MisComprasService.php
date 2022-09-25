<?php

namespace src\tienda_virtual\services;

use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\database\services\categories\ArmarPCFlujoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\database\services\categories\MonedaService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TSession;
use src\tienda_virtual\database\repositories\categories\OfertaRepository;
use PDO;
use Monolog\Logger;

class MisComprasService
{
    use TConnection;
    use TLogger;
    use TSession;

    protected OfertaRepository $OfertasRepository;
    protected PublicacionService $PublicacionService;
    protected ProductoService $productoService;
    protected MonedaService $monedaService;

    public function __construct(PDO $pdo, Logger $logger)
    {
        $this->setConnection($pdo);
        $this->setLogger($logger);
        $this->OfertasRepository = new OfertaRepository($logger, $pdo);
        $this->PublicacionService = new PublicacionService($pdo, $logger);
        $this->productoService = new ProductoService($pdo, $logger);
        $this->monedaService = new MonedaService($pdo, $logger);
    }

    public function RecuperarCarritoEspecifico (String $id_carrito){
        if ($id_carrito != "") {
            $carrito = $this->MisComprasService->addItem($id_carrito);
            $moneda = $this->monedaService->find($carrito["id_moneda"])[0];
            $miscompras["producto"] = $this->productoService->find($carrito["id_producto"])[0];
            $miscompras["publicacion"] = $carrito;
            $miscompras["moneda"] = $moneda;
            $miscompras=[];
        }
        return $miscompras;
    }
}