<?php

namespace src\tienda_virtual\database\services;

use Exception;
use Monolog\Logger;
use PDO;

class GrupoCategoriaService extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\GrupoCategoriaRepository");
    }

    public function create($nombre, $activo) : bool
    {
        try {
            $grupoCategoria = $this->repository->createInstance([
                "nombre"=>$nombre,
                "activo"=>$activo
            ]);
            $this->repository->save($grupoCategoria);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}