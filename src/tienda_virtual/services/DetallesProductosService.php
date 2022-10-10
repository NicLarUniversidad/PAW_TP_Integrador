<?php


namespace src\tienda_virtual\services;


use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\database\services\categories\ArmarPCFlujoService;
use src\tienda_virtual\database\services\categories\MonedaService;
use src\tienda_virtual\database\services\products\FotografiaProductoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TSession;
use src\tienda_virtual\database\repositories\products\ProductoRepository;
use PDO;
use Monolog\Logger;

class DetallesProductosService
{
    use TConnection;
    use TLogger;
    use TSession;

    protected ProductoRepository $ProductosRepository;
    protected PublicacionService $PublicacionService;
    protected ProductoService $productoService;
    protected FotografiaProductoService $fotografiaProductoService;
    protected MonedaService $monedaService;

     public function __construct(PDO $pdo, Logger $logger)
        {
            $this->setConnection($pdo);
            $this->setLogger($logger);
            $this->ProductosRepository = new ProductoRepository($logger, $pdo);
            $this->PublicacionService = new PublicacionService($pdo, $logger);
            $this->productoService = new ProductoService($pdo, $logger);
            $this->fotografiaProductoService = new FotografiaProductoService($pdo, $logger);
            $this->monedaService = new MonedaService($pdo, $logger);
        }


    public function RecuperarDetalles (String $id_publicacion)
    {
        $data = $this->ProductosRepository->findAll();
        $detalles = [];
        foreach ($data as $detalle) {
            $publicacion = $this->PublicacionService->find($detalle["id_publicacion"])[0];
            $moneda = $this->monedaService->find($publicacion["id_moneda"])[0];
            $detalle["producto"] = $this->productoService->find($publicacion["id_producto"])[0];
            $detalle["publicacion"] = $publicacion;
            $detalle["foto"] = $this->fotografiaProductoService->findByProductoId($detalle["producto"]["id"])[0] ?? [];
            $detalle["moneda"] = $moneda;
            $detalles[] = $detalle;
        }
        return $detalles;
    }


}