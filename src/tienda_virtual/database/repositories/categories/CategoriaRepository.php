<?php


namespace src\tienda_virtual\database\repositories\categories;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\repositories\Repository;

class CategoriaRepository extends Repository
{
    private SubCategoriaRepository $subCategoriaRepository;
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "categoria", "categories\\CategoriaModel");
        $this->subCategoriaRepository = new SubCategoriaRepository($logger, $connection);
    }

    public function getByGroupId($groupId) : array
    {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_grupo_categoria"=>$groupId])
            ->execute();
    }

    public function getSubCategories($groupId) : array {
        $categories = $this->getByGroupId($groupId);
        $subCategories = [];
        foreach ($categories as $category) {
            $subCategories_ = $this->subCategoriaRepository->getByCategoryId($category["id"]);
            $subCategories = array_merge($subCategories, $subCategories_);
        }
        return $subCategories;
    }
}