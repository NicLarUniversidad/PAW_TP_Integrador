<?php


namespace src\tienda_virtual\database\services\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\categories\SubCategoriaService;
use src\tienda_virtual\database\services\DatabaseService;
use src\tienda_virtual\services\FileService;
use src\tienda_virtual\services\RequestService;

class FotografiaProductoService extends DatabaseService
{
    private ProductoService $productoService;
    private FileService $fileService;
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "products\\FotografiaProductoRepository");
        $this->productoService = new ProductoService($PDO, $logger);
        $this->fileService = new FileService();
    }

    public function attachData(array $data = []): array
    {
        $data = $this->attachMetadata(parent::attachData($data));
        return $this->formatFieldName($data,"id_producto","Producto","descripcion", $this->productoService->findAll());
    }

    public function attachInsertData(array $data = []) : array {
        $data = $this->attachMetadata(parent::attachInsertData($data));
        return $this->formatFieldNameInsert($data, "id_producto", "Producto");
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Fotografías de Productos";
        $data["register-url"] = "backoffice-fotografia-producto";
        $data["item-url"] = "backoffice-fotografia-producto-item";
        $data["insert-url"] = "backoffice-fotografia-producto-insert";
        $data["register"]["title"] = "Agregar relación Producto con Sub Categoría";
        $data = $this->dataSetSelect($data, "id_producto", $this->buildOptionsProducto());
        $data = $this->dataSetFile($data, "url");
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }

    private function buildOptionsProducto()
    {
        $options = [];
        $productos = $this->productoService->findAll();
        foreach ($productos as $producto) {
            $options[(string)$producto["id"]] = $producto["descripcion"];
        }
        return $options;
    }

    public function saveByABMForm(RequestService $requestService, $archivo): void
    {
        $model = $this->repository->getModelInstance();
        foreach ($model->getTableFields() as $field => $value) {
            if ($field != "url") {
                $key = "abm-" . $field;
                $model->setField($field, $requestService->get($key) ?? "");
            } else {
                $producto = $this->productoService->find($requestService->get("id_producto"));
                $photographs = $this->repository->findByProducto($producto);
                $this->fileService->save($producto["url"], (count($photographs) + 1) .".jpg", $archivo, file_get_contents($archivo['tmp_name']));
            }
        }
        $this->save($model);
    }
}