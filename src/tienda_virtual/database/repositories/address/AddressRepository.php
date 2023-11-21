<?php

namespace src\tienda_virtual\database\repositories\address;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;
use src\tienda_virtual\services\UserService;

class AddressRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "direccion", "address\\AddressModel");
    }

    public function addAddress($zipCode, $provinceId, $locationId, $street, $streetNumber, $departmentNumber) : array
    {
        $model = $this->getModelInstance();
        $model->setField("provincia", $provinceId);
        $model->setField("ciudad", $locationId);
        $model->setField("localidad", "-");
        $model->setField("calle", $street);
        $model->setField("numero", $streetNumber);
        $model->setField("medio", "-");
        $model->setField("piso", "-");
        $model->setField("departamento", $departmentNumber);
        $model->setField("codigo_postal", $zipCode);
        $model->setField("activo", "SI");
        $this->save($model);
        return $model->getTableFields();
    }
}