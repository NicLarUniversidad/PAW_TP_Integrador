<?php

namespace src\tienda_virtual\database\repositories\address;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class LocationRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "localidad", "address\\LocationModel");
    }

    public function findByProvince($provinceId): array
    {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_provincia"=>$provinceId])
            ->execute();
    }
}