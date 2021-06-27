<?php

namespace src\tienda_virtual\database\models;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\QueryBuilder;
use src\tienda_virtual\exceptions\IndexNotFoundException;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;

class Model
{
    use TLogger;
    use TConnection;

    public static Logger $log;
    public static PDO $pdo;

    public static function init(Logger $log, PDO $connection) {
        Model::$log = $log;
        Model::$pdo = $connection;
    }

    public static function factory(String $className) {
        $path = "src\\tienda_virtual\\database\\models\\{$className}";
        $model = new $path();
        $model->setLogger(Model::$log);
        $model->setConnection(Model::$pdo);
        $model->loadQueryBuilder();
        return $model;
    }

    public static function createQueryBuilder() : QueryBuilder {
        return new QueryBuilder(Model::$pdo, Model::$log);
    }

    protected array $tableFields = array();
    protected QueryBuilder $queryBuilder;

    public function __construct()
    {
        $this->setField("id","");
    }

    public function getTableFields() : array {
        return $this->tableFields;
    }

    public function setFields(array $fields) : void {
        $this->tableFields = $fields;
    }

    public function setField(String $field, String $value) : void {
        $this->tableFields[$field] = $value;
    }

    /**
     * @throws IndexNotFoundException
     */
    public function getField(String $field) : String {
        if (array_key_exists($field, $this->tableFields)){
            return $this->tableFields[$field];
        }
        throw new IndexNotFoundException("No halló el indice \"$field\": $this->tableFields");
    }

    public function loadQueryBuilder() : void {
        if (! isset($this->queryBuilder)) {
            if (!is_null($this->logger) && !is_null($this->connection)) {
                $this->queryBuilder = new QueryBuilder($this->connection, $this->logger);
            }
        }
    }
}