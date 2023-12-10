<?php

namespace src\tienda_virtual\database;

use Monolog\Logger;
use PDO;

class QueryBuilder
{
    public static string $DATABASE_NAME = "";
    private PDO $pdo;
    private Logger $logger;
    private string $query;
    private string $querySecondPart;
    private string $tableName;
    private array $values = [];
    private array $updateValues = [];

    private string $type = "";

    public function __construct(PDO $pdo, Logger $logger, $tableName = "")
    {
        $this->pdo = $pdo;
        $this->logger = $logger;
        $this->query = "";
        $this->querySecondPart = "";
        $this->tableName = $tableName;
    }

    public function select(Array $fields = []) : QueryBuilder {
        $this->query = "SELECT ";
        $primero = true;
        foreach ($fields as $field => $value) {
            if (! $primero) {
                $this->query .= ",";
            } else {
                $primero = false;
            }
            $this->query .= " $field";
        }
        $this->type = "select";
        return $this;
    }

    public function selectTopSkippable(Array $fields = [], int $top = 1, int $skip = 0) : QueryBuilder {
        $this->query = "SELECT ";
        $this->querySecondPart = " LIMIT $top OFFSET $skip;";
        $primero = true;
        foreach ($fields as $field => $value) {
            if (! $primero) {
                $this->query .= ",";
            } else {
                $primero = false;
            }
            $this->query .= " A.$field";
        }
        $this->type = "selectSkippable";
        return $this;
    }

    public function count() : QueryBuilder {
        $this->query = "SELECT COUNT(A.id) AS C ";
        $this->type = "count";
        return $this;
    }

    public function from(string $table) : QueryBuilder {
    $this->query .= " FROM `" . QueryBuilder::$DATABASE_NAME . "`.`$table` A";
        return $this;
    }

    public function join(string $table, string $alias, string $fk, string $field, string $aliasFk = "A") : QueryBuilder {
        $this->query .= " INNER JOIN `" . QueryBuilder::$DATABASE_NAME . "`.`$table` $alias";
        $this->query .= " ON $alias.$field=$aliasFk.$fk ";
        return $this;
    }

    public function where(array $values = []) : QueryBuilder {
        $this->query .= " WHERE ";
        $this->values = $values;
        $primero = true;
        foreach ($this->values as $field => $value) {
            if (! $primero) {
                $this->query .= " AND ";
            } else {
                $primero = false;
            }
            $this->query .= "$field = :$field";
        }
        return $this;
    }

    public function whereLike2(array $values = [], $alias = "") : QueryBuilder {
        $this->query .= " WHERE ";
        $this->values = $values;
        $primero = true;
        foreach ($this->values as $field => $value) {
            if (! $primero) {
                $this->query .= " AND ";
            } else {
                $primero = false;
            }
            if ($alias != "") {
                $this->query .= "$alias.$field LIKE :$field";
            } else {
                $this->query .= "$field LIKE :$field";
            }
        }
        $this->logger->info("whereLike query:[" . $this->query . "]");
        return $this;
    }

    public function whereAnd(array $values = [], $alias = "") : QueryBuilder {
        foreach ($values as $field => $value) {
            $this->query .= " AND ";
            if ($alias == "") {
                $this->query .= "$field = :$field";
            } else {
                $this->query .= "$alias.$field = :$field";
            }
            $this->values[$field] = $value;
        }
        $this->logger->info("add to where an and query:[" . $this->query . "]");
        return $this;
    }

    public function whereLike(array $values = []) : QueryBuilder {
        $this->query .= " WHERE ";
        $this->values = $values;
        $primero = true;
        foreach ($this->values as $field => $value) {
            if (! $primero) {
                $this->query .= " AND ";
            } else {
                $primero = false;
            }
            $this->query .= "$field LIKE :$field";
        }
        $this->logger->info("whereLike query:[" . $this->query . "]");
        return $this;
    }

    public function between(String $campo, String $turno, int $minutos = 30) : QueryBuilder {
        if (!isset($this->values)) {
            $this->values = Array();
        }
        $this->query .= " WHERE ";
        $this->values[$campo] = $turno;
        $this->query .= "$campo <= :$campo AND";
        $this->query .= " DATE_ADD($campo, INTERVAL $minutos MINUTE) >= :$campo";
        $this->type = "between";
        return $this;
    }

    public function insert(string $table, array $values) : QueryBuilder {
        $this->query = "INSERT INTO `" . QueryBuilder::$DATABASE_NAME . "`.`$table` (";
        $this->values = $values;
        $postQuery = "(";
        $primero = true;
        $dummy = "(";
        foreach ($this->values as $field => $value) {
            if ($field<>"id") {
                if (!$primero) {
                    $this->query .= ",";
                    $postQuery .= ",";
                    $dummy .= ",";
                } else {
                    $primero = false;
                }
                $this->query .= " $field";
                $postQuery .= " :$field";
                $dummy .= " $value";
            } else {
                unset($this->values[$field]);
            }
        }
        $this->logger->info("Prepared: $this->query) VALUES  $dummy)");
        $this->query .= ") VALUES " . $postQuery . ")";
        $this->type = "insert";
        return $this;
    }

    public function update(string $table, array $values) : QueryBuilder {
        $this->query = "UPDATE  `" . QueryBuilder::$DATABASE_NAME . "`.`$table` SET ";
        $this->updateValues = $values;
        $primero = true;
        foreach ($this->updateValues as $field => $value) {
            if (! $primero) {
                $this->query .= ",";
            } else {
                $primero = false;
            }
            $this->query .= " $field=:$field";
        }
        $this->type = "update";
        return $this;
    }

    public function delete(string $table) : QueryBuilder {
        $this->query = "DELETE FROM `" . QueryBuilder::$DATABASE_NAME . "`.`$table`";
        $this->type = "delete";
        return $this;
    }

    public function execute(array $values = []): array
    {
        if (count($values) > 0) {
            $this->values = $values;
        }
        if ($this->type == "selectSkippable") {
            $this->query .= $this->querySecondPart;
        }
        $this->logger->info("Query: ".  $this->query);
        $sentencia = $this->pdo->prepare($this->query);
        foreach ($this->values as $field => $value) {
            $this->logger->info("Binding values: $field => $value");
            $sentencia->bindValue(":$field",$value);
        }
        foreach ($this->updateValues as $field => $value) {
            $sentencia->bindValue(":$field",$value);
        }
        $this->updateValues = [];
        $this->values = [];
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function getLastInsertId() : string {
        return $this->pdo->lastInsertId();
    }



/*---------------------------------Ordenar resultados de búsqueda--------------------------*/
  /*  public function SortPrice(Array $fields = [], int $criterio = 1) : QueryBuilder {
        $this->query = "SELECT ";
        $this->querySecondPart = " Order by $criterio;";
        $primero = true;
        foreach ($fields as $field => $value) {
            if (! $primero) {
                $this->query .= ",";
            } else {
                $primero = false;
            }
            $this->query .= " A.$field";
        }
        $this->type = "SortPrice";
        return $this;
    }*/

    public function orderBy(String $field, String $order = "ASC") : QueryBuilder {
        $order = strtoupper($order);
        if ($order != "ASC" && $order != "DESC") {
            $order = "ASC";
        }
        $this->query .= " ORDER BY $field $order";
        return $this;
    }

}