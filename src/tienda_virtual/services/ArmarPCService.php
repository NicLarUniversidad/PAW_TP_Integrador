<?php


namespace src\tienda_virtual\services;


use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\database\services\categories\ArmarPCFlujoService;
use src\tienda_virtual\database\services\products\ProductoService;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TSession;

class ArmarPCService
{
    use TConnection;
    use TLogger;
    use TSession;

    protected ArmarPCFlujoService $flujoService;
    protected ProductoService $productoService;
    protected PublicacionService $publicacionService;
    protected CarritoService $carritoService;

    public function init() {
        $this->flujoService = new ArmarPCFlujoService($this->connection, $this->logger);
        $this->productoService = new ProductoService($this->connection, $this->logger);
        $this->publicacionService = new PublicacionService($this->connection, $this->logger);
        $this->carritoService = new CarritoService($this->connection, $this->logger);
        $this->carritoService->setSession($this->session);
    }

    public function procesarPaso(String $paso, String $id_publicacion, array $data = []) : array
    {
        $data["fin"] = "NO";
        $pasos = $this->flujoService->findAll();
        if (($paso == "") && (count($pasos) > 0)) {
            $paso = $pasos[0]["id"];
        }
        $actual = null;
        if (isset($paso)) {
            $actual = $this->flujoService->find($paso)[0];
            if ($id_publicacion != "") {
                $this->carritoService->addItem($id_publicacion);
                $siguientePaso = "";
                foreach ($pasos as $p) {
                    if (($p["numero_paso"] > $actual["numero_paso"]) && ($siguientePaso=="")) {
                        $siguientePaso = $p["id"];
                    }
                }
                if ($siguientePaso == "") {
                    //fin del flujo
                    //TODO: mostrar carrito
                    $data["fin"] = "SI";
                    return $data;
                } else {
                    $actual = $this->flujoService->find($siguientePaso)[0];
                }
            }
            $productos = $this->productoService->findBySubCategoriaId($actual["id_sub_categoria"]);
            if (count($productos) > 0) {
                $publicaciones = [];
                foreach ($productos as $producto) {
                    $item = $this->publicacionService->findByProduct($producto[0]);
                    if (count($item) > 0) {
                        $publicaciones[] = $item;
                    }
                }
                $data["productos"] = $publicaciones;
            } else {
                $data["productos"] = [];
            }

        }
        $data["actual"] = $actual;
        $data["pasos"] = $pasos;
        return $data;
    }

}