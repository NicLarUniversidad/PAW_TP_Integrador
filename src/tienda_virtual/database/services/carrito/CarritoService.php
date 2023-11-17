<?php

namespace src\tienda_virtual\database\services\carrito;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\carrito\CarritoModel;
use src\tienda_virtual\database\services\DatabaseService;
use src\tienda_virtual\database\services\products\FotografiaProductoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\database\services\ventas\SolicitudVentaService;
use src\tienda_virtual\database\services\ventas\VentasService;
use src\tienda_virtual\services\LogginService;
use src\tienda_virtual\services\PagoService;
use src\tienda_virtual\services\UserService;
use src\tienda_virtual\traits\TSession;

class CarritoService extends DatabaseService
{
    use TSession;
    protected ItemCarritoService $itemCarritoService;
    protected PublicacionService $publicacionService;
    protected ProductoService $productoService;
    protected FotografiaProductoService $fotografiaProductoService;
    protected PagoService $pagoService;
    protected VentasService $ventasService;
    protected SolicitudVentaService $solicitudVentaService;

    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "carrito\\CarritoRepository");
        $this->itemCarritoService = new ItemCarritoService($PDO, $logger);
        $this->publicacionService = new PublicacionService($PDO, $logger);
        $this->productoService = new ProductoService($PDO, $logger);
        $this->fotografiaProductoService = new FotografiaProductoService($PDO, $logger);
        $this->ventasService = new VentasService($PDO, $logger);
        $this->solicitudVentaService = new SolicitudVentaService($PDO, $logger);
        //$this->pagoService = new PagoService();
    }

    public function init() {

    }

    public function getCarritoId() {
        $usuario = $this->session->get(UserService::$USER_SESSION_NAME);
        return $this->findByUsername($usuario["id"]);
    }

    public function findItems(array $data = []) : array
    {
        $carrito = $this->getCarritoId();
        if ($carrito != "") {
            $items = $this->itemCarritoService->findByCarritoId($carrito);
            $publicaciones = [];
            $montoTotal = 0.0;
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
                $montoTotal += floatval($publicacion["precio_unidad"]);
                $publicaciones[] = $publicacion;
            }
            $data["publicaciones"] = $publicaciones;
            $data["monto_total"] = $montoTotal;
        }
        return $data;
    }

    public function addItem(String $id_publicacion) {
        $id = $this->getCarritoId();
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

    public function setInactice()
    {
        $idCarrito = $this->getCarritoId();
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
        $id = $this->getCarritoId();
        $this->logger->info("Buscando item con id publicacion=" . $idPublication . " carrito=" . $id);
        if ($id != "") {
            $this->logger->info("   Pasó el if");
            $itemsGuardados = $this->itemCarritoService->findByCarritoId($id);
            $this->logger->info("   Busca items");
            $encontrado = false;
            $item = null;
            foreach ($itemsGuardados as $itemGuardado) {
                $this->logger->info("        Comparando con =" . $itemGuardado["id_publicacion"]);
                if ($itemGuardado["id_publicacion"]==$idPublication) {
                    $item = $itemGuardado;
                    $encontrado = true;
                }
            }
            if ($encontrado) {
                $itemCarrito = new CarritoModel();
                $itemCarrito->setFields($item);
                $this->logger->info("        Dando de baja item con id =" . $item["id_publicacion"]);
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
        $idCarrito = $this->getCarritoId();
        $this->logger->info("Se crea ID de pago: id: " . $preferenceId . " | id carrito: " . $idCarrito);
        $carrrito = $this->repository->createInstance();
        $campos = $this->repository->find($idCarrito);
        if (count($campos)>0) {
            $carrrito->setFields($campos[0]);
            $carrrito->setField("pagado", "PAGO_SOLICITADO");
            $carrrito->setField("idPago", $preferenceId);
            $this->solicitudVentaService->createpaymentRequest($idCarrito, $preferenceId);
        }
        $this->repository->update($carrrito);
    }

    /*
     * Función para completar un pago
     */
    public function pay($preferenceId) {
        $paymentRequest = $this->solicitudVentaService->findPendingPaymentByExternalId($preferenceId);
        $this->logger->info("Se completa el pago con ID = " . $preferenceId . " | solicitud: " . serialize($paymentRequest));
        if (count($paymentRequest)==0) {
            $this->logger->error("Se quiso actualizar un id de pago inválido: " . $preferenceId);
        }
        else {
            $carrrito = $this->repository->createInstance();
            $campos = $this->repository->find($paymentRequest[0]["id_carrito"]);
            $this->logger->info("Campos del carrito: = " . serialize($campos));
            if (count($campos)>0) {
                $carrrito->setFields($campos[0]);
                $carrrito->setField("pagado", "PAGADO");
                $carrrito->setField("activo", "NO");
                $this->repository->update($carrrito);
                $items = $this->itemCarritoService->findByCarritoId($campos[0]["id"]);
                $this->ventasService->addSale($campos[0], $items);
                $this->solicitudVentaService->pay($paymentRequest[0]);
            }
        }
    }

    /*
     * Devuelve el último carrito activo del usuario
     */
    private function findByUsername($username)
    {
        $carrito =  $this->repository->findByUsername($username);
        if (count($carrito)>0) {
            return $carrito[0]["id"];
        }
        else {
            return "";
        }
    }

    public function findWithData($id_carrito)
    {
        $carrito = $this->find($id_carrito)[0];
        $items = $this->itemCarritoService->findByCarritoId($carrito["id"]);
        $publicaciones = [];
        foreach ($items as $item) {
            $publicacion = $this->publicacionService->find($item["id_publicacion"])[0];
            $publicacion["producto"] = $publicacion["productos"][0];
            $publicaciones[] = $publicacion;
        }
        $carrito["publicaciones"] = $publicaciones;
        return $carrito;
    }

    public function getActivePurchases() : array
    {
        $sales = $this->ventasService->getActivePurchases();
        return $this->getSalesData($sales);
    }

    public function getPendingPurchases()
    {
        $sales =  $this->ventasService->getPendingPurchases();
        return $this->getSalesData($sales);
    }

    public function getSentPurchases()
    {
        $sales =  $this->ventasService->getSentPurchases();
        return $this->getSalesData($sales);
    }

    public function getReceivedPurchases()
    {
        $sales =  $this->ventasService->getReceivedPurchases();
        return $this->getSalesData($sales);
    }

    private function getSalesData(array $sales) {
        $result = [];
        foreach ($sales as $sale) {
            $sale["carrito"] = $this->findWithData($sale["id_carrito"]);
            //$carrito["publicacion"] = $this->publicacionService->find($carrito["id_publicacion"])[0];
            $result[] = $sale;
        }
        return $result;
    }
}