<?php

namespace src\tienda_virtual\database\services\categories;

use Exception;
use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class GrupoCategoriaService extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\GrupoCategoriaRepository");
    }

    public function create($nombre, $activo) : bool
    {
        try {
            $grupoCategoria = $this->repository->createInstance([
                "descripcion"=>$nombre,
                "activo"=>$activo
            ]);
            $this->repository->save($grupoCategoria);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function attachData(array $data = []): array
    {
        $data = $this->attachMetadata(parent::attachData($data));
        return $this->addAnchor($data, "id_categoria","Agregar Categoría", "backoffice-categoria-item", "id","abm-id_grupo_categoria");
    }

    public function attachInsertData(array $data = []) : array {
        return $this->attachMetadata(parent::attachInsertData($data));
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Grupos de Categorías";
        $data["table-title"] = "Grupos de Categorías";
        $data["register-url"] = "backoffice-grupo-categoria";
        $data["item-url"] = "backoffice-grupo-categoria-item";
        $data["insert-url"] = "backoffice-grupo-categoria-insert";
        $data["register"]["title"] = "Agregar Grupo de Categorías";
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }
}