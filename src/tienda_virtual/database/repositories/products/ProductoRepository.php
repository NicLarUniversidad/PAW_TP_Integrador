<?php


namespace src\tienda_virtual\database\repositories\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\repositories\Repository;

class ProductoRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "producto", "products\\ProductoModel");
    }

    public function save(Model $model) : void {
        $model->setField("carpeta", uniqid());
        parent::save($model);
    }
}