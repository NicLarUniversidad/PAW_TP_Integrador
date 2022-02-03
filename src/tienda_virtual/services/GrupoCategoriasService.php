<?php


namespace src\tienda_virtual\services;


use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\database\services\categories\ArmarPCFlujoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TSession;
use src\tienda_virtual\database\repositories\categories\GrupoCategoriaRepository;
use PDO;
use Monolog\Logger;

class GrupoCategoriasService
{
    use TConnection;
    use TLogger;
    use TSession;

    protected GrupoCategoriaRepository $GrupoCategoriaRepository;

     public function __construct(PDO $pdo, Logger $logger)
        {
            $this->setConnection($pdo);
            $this->setLogger($logger);
            $this->GrupoCategoriaRepository = new GrupoCategoriaRepository($logger, $pdo);
        }


    public function RecuperarGrupoCategorias (){
     return $this->GrupoCategoriaRepository->findAll();
    }

}