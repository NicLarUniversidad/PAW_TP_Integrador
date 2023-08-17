<?php

namespace src\tienda_virtual\database\repositories;

use Exception;
use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\QueryBuilder;
use src\tienda_virtual\services\FileRequestService;
use src\tienda_virtual\services\RequestService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TFileRequest;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\tRequest;

class Repository
{
    use TLogger;
    use TConnection;
    use TRequest;
    use TFileRequest;
    protected QueryBuilder $queryBuilder;
    protected string $tabla;
    protected string $modelo;

    public function __construct(Logger $logger, PDO $connection, $tabla = "", $modelo = "")
    {
        $this->setLogger($logger);
        $this->setConnection($connection);
        $this->queryBuilder = new QueryBuilder($connection, $logger);
        $this->tabla = $tabla;
        $this->modelo = "src\\tienda_virtual\\database\\models\\" . $modelo;
        $this->setRequest(new RequestService());
        $this->setFileRequest(new FileRequestService());
    }
    public function findAll() : array {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->execute();
    }

    public function find($id): array {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id"=>$id])
            ->execute();
    }

    public function save(Model $model) : void {
        $result = $this->queryBuilder->insert($this->tabla,$model->getTableFields())
            ->execute();
        try {
            $model->setField("id", $this->queryBuilder->getLastInsertId());
        }catch (Exception $e) {
            //ignore
        }
    }

    public function update(Model $model) : void {
        $fields = $model->getTableFields();
        unset($fields["id"]);
        $this->queryBuilder->update($this->tabla, $fields)
            ->where(["id"=>$model->getTableFields()["id"]])
            ->execute();
    }

    public function delete(Model $model) : void {
        $this->queryBuilder->delete($this->tabla)
            ->where(["id"=>$model->getTableFields()["id"]])
            ->execute();
    }

    public function deleteById($id) : void {
        $this->queryBuilder->delete($this->tabla)
            ->where(["id"=>$id])
            ->execute();
    }



    public function getModelo() : ?string {
        return $this->modelo;
    }

    public function createInstance(array $fields = null) : Model {
        $className = $this->getModelo();
        $model = new $className();
        if (!is_null($fields)) {
            $model->setFields($fields);
        }
        return $model;
    }

    public function getModelInstance() : Model
    {
        return new $this->modelo();
    }

    public function query($field, $value) : array
    {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->whereLike([$field=>"%" . $value . "%"])
            ->execute();
    }
}