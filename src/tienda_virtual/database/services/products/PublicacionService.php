<?php


namespace src\tienda_virtual\database\services\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\categories\MonedaService;
use src\tienda_virtual\database\services\DatabaseService;

class PublicacionService extends DatabaseService
{
    private MonedaService $monedaService;
    private ProductoService $productoService;
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "products\\PublicacionRepository");
        $this->monedaService = new MonedaService($PDO, $logger);
        $this->productoService = new ProductoService($PDO, $logger);
    }

    public function attachData(array $data = []): array
    {
        $data = $this->formatFieldName($this->attachMetadata(parent::attachData($data)),
            "fecha_entrada","Fecha de entrada");
        $data = $this->formatFieldName($data,"cantidad_inicial","Cantidad inicial");
        $data = $this->formatFieldName($data,"id_producto","Producto","descripcion", $this->productoService->findAll());
        $data = $this->formatFieldName($data,"id_moneda","Moneda","nombre", $this->monedaService->findAll());
        return $this->formatFieldName($data,"precio_unidad","Precio unidad");
    }

    public function attachInsertData(array $data = []) : array {
        $data = $this->attachMetadata(parent::attachInsertData($data));
        $data = $this->ignoreField($data,"fecha_entrada");
        $data = $this->formatFieldNameInsert($data, "precio_unidad", "Precio unidad");
        $data = $this->formatFieldNameInsert($data,"cantidad_inicial","Cantidad inicial");
        $data = $this->formatFieldNameInsert($data,"id_producto","Producto","descripcion", $this->productoService->findAll());
        return $this->formatFieldNameInsert($data, "id_moneda", "Moneda");
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Publicaciones";
        $data["register-url"] = "backoffice-publicacion";
        $data["item-url"] = "backoffice-publicacion-item";
        $data["insert-url"] = "backoffice-publicacion-insert";
        $data["register"]["title"] = "Agregar publicación";
        $data = $this->dataSetSelect($data, "id_producto", $this->buildOptionsProducto());
        return $this->dataSetSelect($data, "id_moneda", $this->buildOptionsMoneda());
        /*return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);*/
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

    public function buscar($parametros)
    {
        return $this->repository->buscar($parametros);
    }

    public function findByProduct($producto) : array
    {
        $publicaciones = $this->repository->findByProductId($producto["id"]);
        $publicacion = [];
        if (count($publicaciones) > 0) {
            $publicacion = $publicaciones[0];
            $publicacion["producto"] = $producto;
        }
        return $publicacion;
    }

    public function find($id) : array {
        $publicacion = parent::find($id);
        $this->logger->debug(json_encode($publicacion));
        if (array_key_exists("id_producto", $publicacion[0])) {
            $publicacion[0]["productos"] = $this->productoService->find($publicacion[0]["id_producto"]);
            $this->logger->debug(json_encode($publicacion));
        }
        $this->logger->debug(json_encode($publicacion));
        return $publicacion;
    }
}