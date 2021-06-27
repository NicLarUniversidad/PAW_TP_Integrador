<?php

namespace src\tienda_virtual\database;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\repositories\Repository;

class DatabaseService
{
    protected Repository $repository;

    public function __construct(PDO $PDO, Logger $logger, string $repositoryName)
    {
        $repositoryClass = "src\\clinical\\database\\repositories\\" . $repositoryName;
        $this->repository = new $repositoryClass($logger, $PDO);
    }

    public function findAll() : array {
        return $this->repository->findAll();
    }

    public function find($id) : array {
        return $this->repository->find($id);
    }

    public function save(Model $model) : void {
        $this->repository->save($model);
    }

    public function update(Model $model) : void {
        $this->repository->update($model);
    }

    public function delete(Model $model) : void {
        $this->repository->delete($model);
    }
}