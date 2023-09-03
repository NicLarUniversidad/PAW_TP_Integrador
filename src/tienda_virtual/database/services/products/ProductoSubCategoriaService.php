<?php


namespace src\tienda_virtual\database\services\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\categories\MonedaService;
use src\tienda_virtual\database\services\categories\SubCategoriaService;
use src\tienda_virtual\database\services\DatabaseService;

class ProductoSubCategoriaService extends DatabaseService
{
    private ProductoService $productoService;
    private SubCategoriaService $subCategoriaService;
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "products\\ProductoSubCategoriaRepository");
        $this->productoService = new ProductoService($PDO, $logger);
        $this->subCategoriaService = new SubCategoriaService($PDO, $logger);
    }

    public function attachData(array $data = []): array
    {
        $data = $this->formatFieldName($this->attachMetadata(parent::attachData($data)),
            "id_sub_categoria","Sub Categoría", "descripcion", $this->subCategoriaService->findAll());
        return $this->formatFieldName($data,"id_producto","Producto","descripcion", $this->productoService->findAll());
    }

    public function attachInsertData(array $data = []) : array {
        $data = $this->attachMetadata(parent::attachInsertData($data));
        $data = $this->formatFieldNameInsert($data, "id_sub_categoria", "Sub Categoría");
        return $this->formatFieldNameInsert($data, "id_producto", "Producto");
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Productos";
        $data["register-url"] = "backoffice-producto-sub-categoria";
        $data["item-url"] = "backoffice-producto-sub-categoria-item";
        $data["insert-url"] = "backoffice-producto-sub-categoria-insert";
        $data["register"]["title"] = "Agregar relación Producto con Sub Categoría";
        $data = $this->dataSetSelect($data, "id_producto", $this->buildOptionsProducto());
        $data = $this->dataSetSelect($data, "id_sub_categoria", $this->buildOptionsSubCategoria());
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

    private function buildOptionsSubCategoria()
    {
        $options = [];
        $subCategorias = $this->subCategoriaService->findAll();
        foreach ($subCategorias as $sub) {
            $options[(string)$sub["id"]] = $sub["descripcion"];
        }
        return $options;
    }

    public function findBySubCategoriaId($id_sub_categoria) : array
    {
        return $this->repository->findBySubCategoriaId($id_sub_categoria);
    }

    public function findByProductId($productId)
    {
        return $this->repository->query("id_producto", $productId);
    }
}