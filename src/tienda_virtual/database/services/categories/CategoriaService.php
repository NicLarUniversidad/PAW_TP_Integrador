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

    public function attachData(string $data = null): array
    {
        return $this->formatFieldName($this->attachMetadata(parent::attachData($data)),
            "id_grupo_categoria","Grupo Categoría","descripcion",$this->grupoCategoriaService->findAll());
    }

    public function attachInsertData(string $data = null) : array {
        return $this->attachMetadata(parent::attachInsertData($data));
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