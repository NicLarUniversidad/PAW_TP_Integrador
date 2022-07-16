<?php


namespace src\tienda_virtual\database\repositories\categories;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class SubCategoriaRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "sub_categoria", "categories\\SubCategoriaModel");
    }

    public function getByCategoryId($categoryId) : array
    {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_categoria"=>$categoryId])
            ->execute();
    }
}