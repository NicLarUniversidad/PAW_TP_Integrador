<?php

namespace src\tienda_virtual\database\services;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\repositories\Repository;
use src\tienda_virtual\exceptions\IndexNotFoundException;
use src\tienda_virtual\services\RequestService;

class DatabaseService
{
    protected Repository $repository;

    public function __construct(PDO $PDO, Logger $logger, string $repositoryName)
    {
        $repositoryClass = "src\\tienda_virtual\\database\\repositories\\" . $repositoryName;
        $this->repository = new $repositoryClass($logger, $PDO);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function find($id): array
    {
        return $this->repository->find($id);
    }

    public function save(Model $model): void
    {
        $this->repository->save($model);
    }

    public function update(Model $model): void
    {
        $this->repository->update($model);
    }

    public function delete(Model $model): void
    {
        $this->repository->delete($model);
    }

    public function attachData(array $data = []): array
    {
        $data = $this->attachInsertData($data);
        $model = $this->repository->getModelInstance();
        foreach ($model->getTableFields() as $field => $value) {
            $newField["name"] = $field;
            $newField["id"] = $field;
            $newField["required"] = "true";
            $newField["type"] = "text";
            $data["fields"][$field] = $newField;
        }
        $models = $this->repository->findAll();
        $data["tuples"] = [];
        foreach ($models as $m) {
            $tupleData = [];
            foreach ($model->getTableFields() as $field => $value) {
                $tupleData[$field] = [];
                $tupleData[$field]["value"] = $m[$field];
                $tupleData[$field]["description"] = $m[$field];
                $tupleData[$field]["required"] = "true";
                $tupleData[$field]["type"] = "text";
            }
            $data["tuples"][] = $tupleData;
        }
        return $data;
    }

    public function attachInsertData(array $data = []): array
    {
        if (is_null($data)) {
            $data = [];
        }
        $model = $this->repository->getModelInstance();
        $newField = [];
        foreach ($model->getTableFields() as $field => $value) {
            $newField["name"] = $field;
            $newField["id"] = $field;
            $newField["required"] = "true";
            $newField["type"] = "text";
            $data["fields"][$field] = $newField;
        }
        return $data;
    }

    public function saveByDefaultABMForm(RequestService $requestService): void
    {
        $model = $this->repository->getModelInstance();
        foreach ($model->getTableFields() as $field => $value) {
            $key = "abm-" . $field;
            $model->setField($field, $requestService->get($key) ?? "");
        }
        $this->save($model);
    }

    public function updateByDefaultABMForm(RequestService $requestService)
    {
        $model = $this->repository->getModelInstance();
        foreach ($model->getTableFields() as $field => $value) {
            $key = "abm-" . $field;
            $model->setField($field, $requestService->get($key) ?? "");
        }
        $this->update($model);
    }

    public function dataSetSelect(array $data, string $field, array $options): array
    {
        $data["fields"][$field]["type"] = "select";
        $data["fields"][$field]["options"] = [];
        foreach ($options as $value => $description) {
            $option = [];
            $option["value"] = $value;
            $option["description"] = $description;
            $data["fields"][$field]["options"][] = $option;
        }
        return $data;
    }

    public function dataSetFile(array $data, string $field): array
    {
        //$data["fields"][$field]["name"] = "Archivo";
        $data["fields"][$field]["type"] = "file";
        return $data;
    }

    public function deleteById($id): void
    {
        $this->repository->deleteById($id);
    }

    /**
     * @throws IndexNotFoundException
     */
    public function completeFormValues($id, RequestService $request): array
    {
        $values = [];
        $model = $this->repository->find($id);
        if (count($model) > 0) {
            foreach ($model[0] as $field => $value) {
                if (is_null($request->get("abm-" . $field))) {
                    $values[$field] = $model[0][$field] ?? "";
                } else {
                    $values[$field] = $request->get("abm-" . $field);
                }
            }
        } else {
            $model = $this->repository->getModelInstance();
            foreach ($model->getTableFields() as $field => $value) {
                if (is_null($request->get("abm-" . $field))) {
                    $values[$field] = $model->getField($field) ?? "";
                } else {
                    $values[$field] = $request->get("abm-" . $field);
                }
            }
        }
        return $values;
    }

    public function formatFieldNameInsert(array $data, string $field, string $name): array
    {
        $data["fields"][$field]["name"] = $name;
        return $data;
    }

    public function formatFieldName(array $data, string $field, string $name, String $modelDesc = "nombre", array $mapValues = []): array
    {
        $data = $this->formatFieldNameInsert($data, $field, $name);
        $tuples = [];
        foreach ($data["tuples"] as $tuple) {
            foreach ($mapValues as $model) {
                if ($tuple[$field]["value"] == $model["id"]) {
                    $tuple[$field]["description"] = $model[$modelDesc];
                }
            }
            $tuples[] = $tuple;
        }
        $data["tuples"] = $tuples;
        return $data;
    }

    public function addAnchor(array $data, String $columnId, String $columnName, String $url, String $idKey, String $paramId = "parent_id") : array {
        $field["name"] = $columnName;
        $field["id"] = $columnId;
        $field["type"] = "button-add";
        $data["fields"][$columnId] = $field;
        $tuples = [];
        foreach ($data["tuples"] as $tuple) {
            $tuple[$columnId]["type"] = "button-add";
            $tuple[$columnId]["href"] = $url . "?$paramId=" . $tuple[$idKey]["value"];
            $tuples[] = $tuple;
        }
        $data["tuples"] = $tuples;
        return $data;
    }
}