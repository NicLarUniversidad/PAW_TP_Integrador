<?php


namespace src\tienda_virtual\database\services\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\categories\MonedaService;
use src\tienda_virtual\database\services\DatabaseService;

class StockService extends DatabaseService
{
    private MonedaService $monedaService;
    private ProductoService $productoService;
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "products\\StockRepository");
        $this->monedaService = new MonedaService($PDO, $logger);
        $this->productoService = new ProductoService($PDO, $logger);
    }

    public function attachData(array $data = []): array
    {
        $data = $this->formatFieldName($this->attachMetadata(parent::attachData($data)),
            "fecha_entrada","Fecha de entrada");
        $data = $this->formatFieldName($data,"cantidad_inicial","Cantidad inicial");
        $data = $this->formatFieldName($data,"costo_unidad","Costo unidad");
        $data = $this->formatFieldName($data,"id_producto","Producto","descripcion", $this->productoService->findAll());
        return $this->formatFieldName($data,"id_moneda","Moneda","nombre", $this->monedaService->findAll());
    }

    public function attachInsertData(array $data = []) : array {
        $data = $this->attachMetadata(parent::attachInsertData($data));
        $data = $this->ignoreField($data, "fecha_entrada");
        $data = $this->formatFieldNameInsert($data, "cantidad_inicial", "Cantidad inicial");
        $data = $this->formatFieldNameInsert($data, "costo_unidad", "Costo unidad");
        $data = $this->formatFieldNameInsert($data, "id_producto", "Producto");
        return $this->formatFieldNameInsert($data, "id_moneda", "Moneda");
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Stock";
        $data["register-url"] = "backoffice-stock";
        $data["item-url"] = "backoffice-stock-item";
        $data["insert-url"] = "backoffice-stock-insert";
        $data["register"]["title"] = "Agregar producto";
        $data = $this->dataSetSelect($data, "id_producto", $this->buildOptionsProducto());
        return $this->dataSetSelect($data, "id_moneda", $this->buildOptionsMoneda());
    }

    private function buildOptionsMoneda(): array
    {
        $options = [];
        $monedas = $this->monedaService->findAll();
        foreach ($monedas as $moneda) {
            $options[(string)$moneda["id"]] = $moneda["nombre"];
        }
        return $options;
    }

    private function buildOptionsProducto(): array
    {
        $options = [];
        $tuples = $this->productoService->findAll();
        foreach ($tuples as $tuple) {
            $options[(string)$tuple["id"]] = $tuple["descripcion"];
        }
        return $options;
    }
}