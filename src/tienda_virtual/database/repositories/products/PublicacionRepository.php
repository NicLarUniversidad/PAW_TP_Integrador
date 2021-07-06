<?php


namespace src\tienda_virtual\database\repositories\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\services\products\FotografiaProductoService;
use src\tienda_virtual\database\services\products\ProductoService;

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

    public function buscar(String $parametros) : array
    {
        //TODO: agregar lógica del buscador
        $productoService = new ProductoService($this->connection, $this->logger);
        $fotografiaProductoService = new FotografiaProductoService($this->connection, $this->logger);
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
        $publicaciones = $this->findAll();
        $result = [];
        foreach ($publicaciones as $publicacion) {
            $publicacion["producto"] = $productoService->find($publicacion["id_producto"])[0];
            $publicacion["fotografias"] = $fotografiaProductoService->findByProductoId($publicacion["id_producto"]);
            $result[] = $publicacion;
        }
        return $result;
    }
}