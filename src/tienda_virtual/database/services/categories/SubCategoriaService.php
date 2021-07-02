<?php


namespace src\tienda_virtual\database\services\categories;


use Exception;
use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class SubCategoriaService extends DatabaseService
{
    private CategoriaService $categoriaService;

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\SubCategoriaRepository");
        $this->categoriaService = new CategoriaService($PDO, $logger);
    }

    public function create($nombre, $activo, $idGrupoCategoria) : bool
    {
        try {
            $grupoCategoria = $this->repository->createInstance([
                "descripcion"=>$nombre,
                "activo"=>$activo,
                "id_sub_categoria"=>$idGrupoCategoria
            ]);
            $this->repository->save($grupoCategoria);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function attachData(array $data = []): array
    {
        return $this->formatFieldName($this->attachMetadata(parent::attachData($data)),
            "id_categoria","Categoría","descripcion",$this->categoriaService->findAll());
    }

    public function attachInsertData(array $data = []) : array {
        $data = $this->formatFieldNameInsert($data, "id_categoria", "Categoría");
        return $this->attachMetadata(parent::attachInsertData($data));
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Sub Categorías";
        $data["table-title"] = "Sub Categorías";
        $data["register-url"] = "backoffice-sub-categoria";
        $data["item-url"] = "backoffice-sub-categoria-item";
        $data["insert-url"] = "backoffice-sub-categoria-insert";
        $data["register"]["title"] = "Agregar Sub Categorías";
        $data = $this->dataSetSelect($data, "id_categoria", $this->buildOptionsCategorias());
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }

    public function buildOptionsCategorias() : array {
        $options = [];
        $categorias = $this->categoriaService->findAll();
        foreach ($categorias as $categoria) {
            $options[(string)$categoria["id"]] = $categoria["descripcion"];
        }
        return $options;
    }
}