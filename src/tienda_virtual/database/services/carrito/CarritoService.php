<?php

namespace src\tienda_virtual\database\services\carrito;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\carrito\CarritoModel;
use src\tienda_virtual\database\services\DatabaseService;
use src\tienda_virtual\database\services\products\FotografiaProductoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\services\LogginService;
use src\tienda_virtual\services\PagoService;
use src\tienda_virtual\traits\TSession;

class CarritoService extends DatabaseService
{
    use TSession;
    protected ItemCarritoService $itemCarritoService;
    protected PublicacionService $publicacionService;
    protected ProductoService $productoService;
    protected FotografiaProductoService $fotografiaProductoService;
    protected PagoService $pagoService;

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "carrito\\CarritoRepository");
        $this->itemCarritoService = new ItemCarritoService($PDO, $logger);
        $this->publicacionService = new PublicacionService($PDO, $logger);
        $this->productoService = new ProductoService($PDO, $logger);
        $this->fotografiaProductoService = new FotografiaProductoService($PDO, $logger);
        //$this->pagoService = new PagoService();
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
                $publicacion["cantidad"] = $item["cantidad"];
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
        if (!isset($id) || $id=="") {
            $carrito = $this->repository->getModelInstance();
            //TODO: quitar mock
            $carrito->setField("id_usuario", LogginService::getUserId());
            $carrito->setField("activo", "SI");
            $carrito->setField("precio_total", "1");
            $carrito->setField("id_moneda", "1");
            $carrito->setField("id_direccion", "1");
            $this->repository->save($carrito);
            $instance = $this->repository->findActiveByUserId(LogginService::$userId);
            $id = $carrito->getField("id");
            $this->session->put("carrito", $id);
        }
        $publicaciones = $this->publicacionService->find($id_publicacion);
        if (!empty($publicaciones)) {
            $publicacion = $publicaciones[0];
            $itemsGuardados = $this->itemCarritoService->findByCarritoId($id);
            $yaEstaGuardado = false;
            $item = null;
            foreach ($itemsGuardados as $itemGuardado) {
                if ($itemGuardado["id_publicacion"]==$id_publicacion) {
                    $item = $itemGuardado;
                    $yaEstaGuardado = true;
                }
            }
            if ($yaEstaGuardado) {
                $this->logger->info("Se agrega cantidad al item con id=" . $id_publicacion);
                $item["cantidad"] = $item["cantidad"]  + 1;
                $itemCarrito = new CarritoModel();
                $itemCarrito->setFields($item);
                $this->logger->info("Cantidad=" . $item["cantidad"] );
                $this->itemCarritoService->update($itemCarrito);
            } else {
                $itemCarrito = $this->itemCarritoService->create($id, $id_publicacion, $publicacion["precio_unidad"], $publicacion["id_moneda"]);
                $this->itemCarritoService->save($itemCarrito);
            }
        } else {
            $this->logger->error("Se ingresó un ID de Publicación inválido: $id_publicacion");
        }
    }

    public function setInactice($idCarrito)
    {
        $carrrito = $this->repository->createInstance();
        $campos = $this->repository->find($idCarrito);
        if (count($campos)>0) {
            $carrrito->setFields($campos[0]);
            $carrrito->setField("activo", "NO");
        }
        $this->repository->update($carrrito);
    }

    public function getPreference()
    {
        //return $this->pagoService->getPreference();
        return "1";
    }

    public function deleteItem($idPublication) {
        $id = $this->session->get("carrito");
        if (!isset($id) || $id=="") {$itemsGuardados = $this->itemCarritoService->findByCarritoId($id);
            $encontrado = false;
            $item = null;
            foreach ($itemsGuardados as $itemGuardado) {
                if ($itemGuardado["id_publicacion"]==$idPublication) {
                    $item = $itemGuardado;
                    $encontrado = true;
                }
            }
            if ($encontrado) {
                $itemCarrito = new CarritoModel();
                $itemCarrito->setFields($item);
                $this->itemCarritoService->delete($itemCarrito);
            }
        }
    }

    /*
     * Función para persistir el pago con todos los items.
     * Se asocia al preference ID de mercado pago
     * que se genera en el backend y se devuelve desde la back-url.
     */
    public function registerPayment($preferenceId) {
        $idCarrito = $this->session->get("carrito");
        $carrrito = $this->repository->createInstance();
        $campos = $this->repository->find($idCarrito);
        if (count($campos)>0) {
            $carrrito->setFields($campos[0]);
            $carrrito->setField("pagado", "PENDIENTE");
            $carrrito->setField("idPago", $preferenceId);
        }
        $this->repository->update($carrrito);
    }

    /*
     * Función para completar un pago
     */
    public function pay($preferenceId) {
        $carrrito = $this->repository->createInstance();
        $campos = $this->repository->findByPreferenceId($preferenceId);
        if (count($campos)>0) {
            $carrrito->setFields($campos[0]);
            $carrrito->setField("pagado", "PAGADO");
            $carrrito->setField("activo", "NO");
        }
        $this->repository->update($carrrito);
        $this->session->delete("carrito");
    }
}