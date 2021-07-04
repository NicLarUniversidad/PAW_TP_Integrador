<?php


namespace src\tienda_virtual\database\services\categories;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class ArmarPCFlujoService extends DatabaseService
{
    private SubCategoriaService $subCategoriaService;

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\ArmarPCFlujoRepository");
        $this->subCategoriaService = new SubCategoriaService($PDO, $logger);
    }

    public function attachData(array $data = []): array
    {
        $data = $this->attachMetadata(parent::attachData($data));
        $data = $this->formatFieldName($data, "id_sub_categoria", "Sub Categoría");
        return $this->formatFieldName($data, "numero_paso", "Número de paso");
    }

    public function attachInsertData(array $data = []) : array {
        $data = $this->attachMetadata(parent::attachInsertData($data));
        $data = $this->formatFieldNameInsert($data, "id_sub_categoria", "Sub Categoría");
        return $this->formatFieldNameInsert($data, "numero_paso", "Número de paso");
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Flujo de Sección Armá tu PC";
        $data["register-url"] = "backoffice-armar-pc-flujo";
        $data["item-url"] = "backoffice-armar-pc-flujo-item";
        $data["insert-url"] = "backoffice-armar-pc-flujo-insert";
        $data["register"]["title"] = "Agregar pasos para armar PC";
        $data = $this->dataSetSelect($data, "id_sub_categoria", $this->buildOptionsSubCategorias());
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }

    private function buildOptionsSubCategorias(): array
    {
        $options = [];
        $categorias = $this->subCategoriaService->findAll();
        foreach ($categorias as $categoria) {
            $options[(string)$categoria["id"]] = $categoria["descripcion"];
        }
        return $options;
    }
}