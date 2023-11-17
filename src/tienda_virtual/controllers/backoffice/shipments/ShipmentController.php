<?php

namespace src\tienda_virtual\controllers\backoffice\shipments;

use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\carrito\CarritoService;
use src\tienda_virtual\database\services\ventas\VentasService;
use src\tienda_virtual\services\TwigPageFinderService;

class ShipmentController extends Controller
{
    protected VentasService $ventasService;
    protected CarritoService $carritoService;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->ventasService = new VentasService($this->connection, $this->logger);
        $this->carritoService = new CarritoService($this->connection, $this->logger);
    }

    public function isAuthorizedUser($method) : bool {
        $isAuthorized = false;
        $idVenta = $this->request->get("id_venta");
        switch ($method) {
            case "showShipments":
            case "showPendingShipments":
            case "showSentShipments":
            case "showReceivedShipments":
            case "showShipmentDetails":
                $isAuthorized = $this->isAdmin();
                break;
            case "sentPackage":
                $isAuthorized = $this->isAdmin() && $this->ventasService->isValidState($idVenta, "ENVIADO");
                break;
            case "receivePackage":
                $isAuthorized = $this->isAdmin() && $this->ventasService->isValidState($idVenta, "RECIBIDO");
                break;
        }
        return $isAuthorized;
    }

    public function showShipments() {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data = [];
        $data["ventas"] = $this->carritoService->getActivePurchases();
        $this->pageFinderService->findFileRute("envios","twig","twig", $cssImports,
            $data,"Gestión de ventas", $jsImports);
    }

    public function showPendingShipments() {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data["ventas"] = $this->carritoService->getPendingPurchases();
        $this->pageFinderService->findFileRute("envios","twig","twig", $cssImports,
            $data,"Gestión de ventas", $jsImports);
    }

    public function showSentShipments() {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data["ventas"] = $this->carritoService->getSentPurchases();
        $this->pageFinderService->findFileRute("envios","twig","twig", $cssImports,
            $data,"Gestión de ventas", $jsImports);
    }

    public function showReceivedShipments() {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data["ventas"] = $this->carritoService->getReceivedPurchases();
        $this->pageFinderService->findFileRute("envios","twig","twig", $cssImports,
            $data,"Gestión de ventas", $jsImports);
    }

    public function showShipmentDetails() {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="paw";
        $jsImports[]="app";
        $data["ventas"] = $this->carritoService->getReceivedPurchases();
        $this->pageFinderService->findFileRute("envios","twig","twig", $cssImports,
            $data,"Gestión de ventas", $jsImports);
    }

    public function sentPackage() {
        $idVenta = $this->request->get("id_venta");
        $this->ventasService->sendPackage($idVenta);
    }

    public function receivePackage() {
        $this->logger->info("ShipmentController->receivePackage()");
        $idVenta = $this->request->get("id_venta");
        $this->ventasService->receivePackage($idVenta);
    }

}