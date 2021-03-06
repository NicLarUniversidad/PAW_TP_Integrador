<?php


namespace src\tienda_virtual\database\services\categories;


use Exception;
use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class CaracteristicaService extends DatabaseService
{

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\CaracteristicaRepository");
    }

    public function create($nombre, $activo, $idGrupoCategoria) : bool
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
        return $this->addAnchor($data, "id_sub_categoria","Agregar Categoría", "backoffice-sub-categoria-item","id","id_sub_categoria");
    }

    public function attachInsertData(array $data = []) : array {
        return $this->attachMetadata(parent::attachInsertData($data));
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Característica";
        $data["table-title"] = "Característica";
        $data["register-url"] = "backoffice-caracteristica";
        $data["item-url"] = "backoffice-caracteristica-item";
        $data["insert-url"] = "backoffice-caracteristica-insert";
        $data["register"]["title"] = "Agregar Grupo de Categorías";
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }
}