<?php

namespace src\tienda_virtual\database\services\address;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class UserAddressService  extends DatabaseService
{

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "address\\UserAddressRepository");
    }

    public function add($addressId, $userId) : array
    {
        $model = $this->repository->getModelInstance();
        $model->setField("id_usuario", $userId);
        $model->setField("id_direccion", $addressId);
        $this->repository->save($model);
        return $model->getTableFields();
    }

    public function findByUserId($id) : array
    {
        return $this->repository->findByUserId($id);
    }

    public function findByUserAndAddress($userId, $addressId)
    {
        return $this->repository->findByUserAndAddress($userId, $addressId);
    }
}