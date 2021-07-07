<?php

namespace src\tienda_virtual\database\services\carrito;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;
use src\tienda_virtual\database\services\products\FotografiaProductoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\services\LogginService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TSession;

class CarritoService extends DatabaseService
{
    use TSession;
    protected ItemCarritoService $itemCarritoService;
    protected PublicacionService $publicacionService;
    protected ProductoService $productoService;
    protected FotografiaProductoService $fotografiaProductoService;

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "carrito\\CarritoRepository");
        $this->itemCarritoService = new ItemCarritoService($PDO, $logger);
        $this->publicacionService = new PublicacionService($PDO, $logger);
        $this->productoService = new ProductoService($PDO, $logger);
        $this->fotografiaProductoService = new FotografiaProductoService($PDO, $logger);
    }

    public function init() {

    }

    public function findItems(array $data = []) : array
    {
        $carrito = $this->session->get("carrito") ?? "";
        if ($carrito != "") {
            $items = $this->itemCarritoService->findByCarritoId($carrito);
            $publicaciones = [];
            foreach ($items as $item) {
                $publicacion = $this->publicacionService->find($item["id_publicacion"])[0];
                $publicacion["nombre"] = $this->productoService->find($publicacion["id_producto"])[0]["descripcion"];
                $fotos = $this->fotografiaProductoService->findByProductoId($publicacion["id_producto"]);
                if (count($fotos) > 0) {
                    $publicacion["foto"] = $fotos[0]["url"];
                } else {
                    $publicacion["foto"] = "";
                }
                $publicaciones[] = $publicacion;
            }
            $data["publicaciones"] = $publicaciones;
        }
        return $data;
    }

    public function addItem(String $id_publicacion) {
        $id = $this->session->get("carrito");
        if (!isset($id)) {
            $carrito = $this->repository->getModelInstance();
            //TODO: quitar mock
            $carrito->setField("id_usuario", LogginService::getUserId());
            $carrito->setField("activo", "SI");
            $carrito->setField("precio_total", "1");
            $carrito->setField("id_moneda", "1");
            $carrito->setField("id_direccion", "1");
            $this->repository->save($carrito);
            $instance = $this->repository->findActiveByUserId(LogginService::$userId)[0];
            $id = $instance["id"];
        }
        $this->session->put("carrito", $id);
        $publicaciones = $this->publicacionService->find($id_publicacion);
        if (count($publicaciones)>0) {
            $publicacion = $publicaciones[0];
            $itemCarrito = $this->itemCarritoService->create($id, $id_publicacion, $publicacion["precio_unidad"], $publicacion["id_moneda"]);
            $this->itemCarritoService->save($itemCarrito);
        } else {
            $this->logger->error("Se ingresó un ID de Publicación inválido: $id_publicacion");
        }
    }
}