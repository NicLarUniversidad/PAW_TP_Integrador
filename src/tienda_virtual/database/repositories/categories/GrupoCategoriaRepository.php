<?php

namespace src\tienda_virtual\database\repositories\categories;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\categories\GrupoCategoriaModel;
use src\tienda_virtual\database\repositories\Repository;

class GrupoCategoriaRepository extends Repository
{
    private CategoriaRepository $categoriaRepository;
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "grupo_categoria", "categories\\GrupoCategoriaModel");
        $this->categoriaRepository = new CategoriaRepository($logger, $connection);
    }

    public function getCategories($groupId) : array {
        return $this->categoriaRepository->getByGroupId($groupId);
    }

    public function getSubCategories($groupId) : array {
        return $this->categoriaRepository->getSubCategories($groupId);
    }
}
