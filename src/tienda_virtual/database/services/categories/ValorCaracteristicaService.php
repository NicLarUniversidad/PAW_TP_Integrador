<?php


namespace src\tienda_virtual\database\services\categories;

use Exception;
use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class ValorCaracteristicaService extends DatabaseService
{
    private CaracteristicaService $caracteristicaService;

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\ValorCaracteristicaRepository");
        $this->caracteristicaService = new CaracteristicaService($PDO, $logger);
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

    public function attachData(string $data = null): array
    {       return $this->formatFieldName($this->attachMetadata(parent::attachData($data)),
        "id_caracteristica","Característica","descripcion",$this->caracteristicaService->findAll());
    }

    public function attachInsertData(string $data = null) : array {
        return $this->attachMetadata(parent::attachInsertData($data));
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Categorías";
        $data["table-title"] = "Categorías";
        $data["register-url"] = "backoffice-valor-caracteristica";
        $data["item-url"] = "backoffice-valor-caracteristica-item";
        $data["insert-url"] = "backoffice-valor-caracteristica-insert";
        $data["register"]["title"] = "Agregar Grupo de Categorías";
        $data = $this->dataSetSelect($data, "id_caracteristica", $this->buildOptionsCaracteristicas());
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }

    public function buildOptionsCaracteristicas() : array {
        $options = [];
        $categorias = $this->caracteristicaService->findAll();
        foreach ($categorias as $categoria) {
            $options[(string)$categoria["id"]] = $categoria["descripcion"];
        }
        return $options;
    }
}