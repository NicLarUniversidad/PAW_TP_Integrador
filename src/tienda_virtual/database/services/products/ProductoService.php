<?php


namespace src\tienda_virtual\database\services\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\categories\MonedaService;
use src\tienda_virtual\database\services\DatabaseService;

class ProductoService extends DatabaseService
{
    private MonedaService $monedaService;
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "products\\ProductoRepository");
        $this->monedaService = new MonedaService($PDO, $logger);
    }

    public function attachData(array $data = []): array
    {
        $data = $this->formatFieldName($this->attachMetadata(parent::attachData($data)),
            "precio_tentativo","Precio tentativo");
        $data = $this->formatFieldName($data,"id_moneda","Moneda","nombre", $this->monedaService->findAll());
        $data = $this->addAnchor($data, "id_fotografia_producto","Agregar Fotografia", "backoffice-fotografia-producto-item", "id","abm-id_producto");
        return $this->addAnchor($data, "id_sub_categoria","Agregar Sub Categoría", "backoffice-producto-sub-categoria-item", "id","abm-id_producto");
    }

    public function attachInsertData(array $data = []) : array {
        $data = $this->attachMetadata(parent::attachInsertData($data));
        $data = $this->formatFieldNameInsert($data, "precio_tentativo", "Precio tentativo");
        return $this->formatFieldNameInsert($data, "id_moneda", "Moneda");
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Productos";
        $data["register-url"] = "backoffice-producto";
        $data["item-url"] = "backoffice-producto-item";
        $data["insert-url"] = "backoffice-producto-insert";
        $data["register"]["title"] = "Agregar producto";
        $data = $this->dataSetSelect($data, "id_moneda", $this->buildOptionsMoneda());
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }

    private function buildOptionsMoneda()
    {
        $options = [];
        $monedas = $this->monedaService->findAll();
        foreach ($monedas as $moneda) {
            $options[(string)$moneda["id"]] = $moneda["nombre"];
        }
        return $options;
    }

    public function findBySubCategoriaId($id_sub_categoria): array
    {
        $productoSubCategoriaService = new ProductoSubCategoriaService($this->connection, $this->logger);
        $relaciones = $productoSubCategoriaService->findBySubCategoriaId($id_sub_categoria);
        $productos = [];
        foreach ($relaciones as $relacion) {
            $productos[] = $this->find($relacion["id_producto"]);
        }
        return $productos;
    }

    public function search(String $param) : array
    {
        $resultados = $this->repository->query("descripcion", $param);
        return $resultados;
    }
}