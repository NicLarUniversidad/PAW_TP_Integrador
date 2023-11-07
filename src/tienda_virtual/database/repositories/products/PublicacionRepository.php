<?php


namespace src\tienda_virtual\database\repositories\products;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\services\categories\OfertaService;
use src\tienda_virtual\database\services\products\FotografiaProductoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\categories\MonedaService;
use src\tienda_virtual\database\services\products\ProductoSubCategoriaService;

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

    public function buscar(String $parametros, $sub_categoria) : array
    {
        //TODO: agregar lógica del buscador
        $productoService = new ProductoService($this->connection, $this->logger);
        $productoSubCategoriaService = new ProductoSubCategoriaService($this->connection, $this->logger);
        $fotografiaProductoService = new FotografiaProductoService($this->connection, $this->logger);
        $ofertaService = new OfertaService($this->connection, $this->logger);
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
                $publicacion["oferta"] = $ofertaService->findByPublicacion($publicacion["id"]);
                if (count($publicacion["oferta"])>0) {
                    $publicacion["oferta"] = $publicacion["oferta"][0];
                    $this->logger->error(serialize($publicacion["oferta"]));
                }
                if (is_null($sub_categoria))
                    $result[] = $publicacion;
                else {
                    $subCategoria = $productoSubCategoriaService->findByProductId($publicacion["producto"]["id"]);
                    if ($subCategoria[0]["id_sub_categoria"] == $sub_categoria) {
                        $result[] = $publicacion;
                    } else {
                        $this->logger->info("Cero coincidencias");
                    }
                }
            }else{
                $this->logger->info("Cero coincidencias");
            }           
        }
        $this->logger->info("Publicaciones: ".json_encode($publicaciones));
        return $result;
    }
}