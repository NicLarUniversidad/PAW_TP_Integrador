<?php


namespace src\tienda_virtual\database\services\categories;


use Exception;
use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class CategoriaService extends DatabaseService
{
    private GrupoCategoriaService $grupoCategoriaService;

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\CategoriaRepository");
        $this->grupoCategoriaService = new GrupoCategoriaService($PDO, $logger);
    }

    public function create($nombre, $activo, $idGrupoCategoria) : bool
    {
        try {
            $grupoCategoria = $this->repository->createInstance([
                "descripcion"=>$nombre,
                "activo"=>$activo,
                "id_grupo_categoria"=>$idGrupoCategoria
            ]);
            $this->repository->save($grupoCategoria);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function attachData(array $data = []): array
    {
        $data = $this->formatFieldName($this->attachMetadata(parent::attachData($data)),
            "id_grupo_categoria","Grupo Categoría","descripcion",$this->grupoCategoriaService->findAll());
        return $this->addAnchor($data, "id_sub_categoria","Agregar Sub Categoría", "backoffice-sub-categoria-item", "id");
    }

    public function attachInsertData(array $data = []) : array {
        $data = $this->attachMetadata(parent::attachInsertData($data));
        return $this->formatFieldNameInsert($data, "id_grupo_categoria", "Grupo Categoría");
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Categorías";
        $data["table-title"] = "Categorías";
        $data["register-url"] = "backoffice-categoria";
        $data["item-url"] = "backoffice-categoria-item";
        $data["insert-url"] = "backoffice-categoria-insert";
        $data["register"]["title"] = "Agregar Grupo de Categorías";
        $data = $this->dataSetSelect($data, "id_grupo_categoria", $this->buildOptionsGrupoCategorias());
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }

    public function getOptionActivos() : array {
        $options = [];
        $option = [];
        $option["SI"] = "Sí";
        $options[] = $option;
        $option = [];
        $option["NO"] = "No";
        $options[] = $option;
        return $options;
    }

    public function buildOptionsGrupoCategorias() : array {
        $options = [];
        $categorias = $this->grupoCategoriaService->findAll();
        foreach ($categorias as $categoria) {
            $options[(string)$categoria["id"]] = $categoria["descripcion"];
        }
        return $options;
    }
}