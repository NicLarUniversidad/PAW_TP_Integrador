<?php


namespace src\tienda_virtual\database\repositories\categories;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class OfertaRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "oferta", "ofertas\\OfertasModel");
    }

    public function findByPublicacion($idPublicacion) {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_publicacion" => $idPublicacion])
            ->execute();
    }
}