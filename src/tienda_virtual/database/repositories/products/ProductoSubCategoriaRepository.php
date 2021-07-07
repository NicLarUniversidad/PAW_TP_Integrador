<?php


namespace src\tienda_virtual\database\repositories\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class ProductoSubCategoriaRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "producto_sub_categoria", "products\\ProductoSubCategoriaModel");
    }

    public function findBySubCategoriaId($id_sub_categoria): array
    {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_sub_categoria"=>$id_sub_categoria])
            ->execute();
    }
}