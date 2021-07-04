<?php


namespace src\tienda_virtual\database\repositories\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\repositories\Repository;

class StockRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "stock", "products\\StockModel");
    }

    public function save(Model $model) : void {
        $model->setField("fecha_entrada", date("Y-m-d H:i:s"));
        parent::save($model);
    }
}