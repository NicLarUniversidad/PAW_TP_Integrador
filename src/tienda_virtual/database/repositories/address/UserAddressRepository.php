<?php

namespace src\tienda_virtual\database\repositories\address;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class UserAddressRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "direccion_usuario", "address\\UserAddressModel");
    }

    public function findByUserId($id) : array
    {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_usuario"=>$id])
            ->execute();
    }

    public function findByUserAndAddress($userId, $addressId)
    {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_usuario"=>$userId, "id_direccion" => $addressId])
            ->execute();
    }
}