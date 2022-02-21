<?php


namespace src\tienda_virtual\services;


use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\database\services\categories\ArmarPCFlujoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\database\services\products\FotografiaProductoService;
use src\tienda_virtual\database\services\categories\MonedaService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TSession;
use src\tienda_virtual\database\repositories\categories\OfertaRepository;
use PDO;
use Monolog\Logger;

class OfertasService
{
    use TConnection;
    use TLogger;
    use TSession;

    protected OfertaRepository $OfertasRepository;
    protected PublicacionService $PublicacionService; 
    protected ProductoService $productoService;
    protected FotografiaProductoService $fotografiaProductoService;
    protected MonedaService $monedaService;

     public function __construct(PDO $pdo, Logger $logger)
        {
            $this->setConnection($pdo);
            $this->setLogger($logger);
            $this->OfertasRepository = new OfertaRepository($logger, $pdo);
            $this->PublicacionService = new PublicacionService($pdo, $logger);
            $this->productoService = new ProductoService($pdo, $logger);
            $this->fotografiaProductoService = new FotografiaProductoService($pdo, $logger);
            $this->monedaService = new MonedaService($pdo, $logger);
        }


    public function RecuperarOfertas (){
        $data=$this->OfertasRepository->findAll();
        $ofertas=[];
        foreach($data as $oferta){
            $publicacion = $this->PublicacionService->find($oferta["id_publicacion"])[0];
            $moneda = $this->monedaService->find($publicacion["id_moneda"])[0];
            $oferta["producto"] = $this->productoService->find($publicacion["id_producto"])[0];
            $oferta["publicacion"] = $publicacion;
            $oferta["foto"] = $this->fotografiaProductoService->findByProductoId($oferta["producto"]["id"])[0] ??[];
            $oferta["moneda"] = $moneda;
            $ofertas[]=$oferta;
        }
        
        return $ofertas;
    }

}