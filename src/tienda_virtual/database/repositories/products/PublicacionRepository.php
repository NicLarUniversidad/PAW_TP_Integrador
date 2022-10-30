<?php


namespace src\tienda_virtual\database\repositories\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\services\products\FotografiaProductoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\categories\MonedaService;

class PublicacionRepository extends \src\tienda_virtual\database\repositories\Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "publicacion", "products\\PublicacionModel");
    }

    public function save(Model $model) : void {
        $model->setField("fecha_entrada", date("Y-m-d"));
        parent::save($model);
    }
    public function findByProductId($id_producto) : array
    {
        $model = new $this->modelo();
        return $this->queryBuilder->select($model->getTableFields())
            ->from($this->tabla)
            ->where(["id_producto"=>$id_producto])
            ->execute();
    }

    public function buscar(String $parametros) : array
    {
        //TODO: agregar lógica del buscador
        $productoService = new ProductoService($this->connection, $this->logger);
        $fotografiaProductoService = new FotografiaProductoService($this->connection, $this->logger);
        $monedaService = new MonedaService($this->connection, $this->logger);
        /*$productos = $productoService->findByName($parametros);
        $publicaciones = [];
        foreach ($productos as $producto) {
            $model = $productoService->getModelInstance();
            $p = $this->queryBuilder->select($model->getTableFields())
                ->from($this->tabla)
                ->where(["id_producto"=>$producto["id"]])
                ->execute();
            array_push($publicaciones, $p);
        }
        return $publicaciones;*/
        $this->logger->info("method buscar() PublicacionRepository");
        $publicaciones = $this->findAll();
        $result = [];
        $busqueda = "SSD";
        foreach ($publicaciones as $publicacion) {
            $texto=strtolower($productoService->find($publicacion["id_producto"])[0]["descripcion"]);
            $this->logger->info("BUSQUEDA: ". $parametros." - TEXTO : ". $texto);
            if (str_contains($texto, strtolower($parametros))){
                $this->logger->info("PRODUCTO#: ".$productoService->find($publicacion["id_producto"])[0]["descripcion"]);
                $publicacion["producto"] = $productoService->find($publicacion["id_producto"])[0];
                $publicacion["fotografias"] = $fotografiaProductoService->findByProductoId($publicacion["id_producto"]);
                $publicacion["moneda"] = $monedaService->find($publicacion["id_moneda"])[0];
                $result[] = $publicacion;
            }else{
                $this->logger->info("Cero coincidencias");
            }           
        }
        $this->logger->info("Publicaciones: ".json_encode($publicaciones));
        return $result;
    }
}