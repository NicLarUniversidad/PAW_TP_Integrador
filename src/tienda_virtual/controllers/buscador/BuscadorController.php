<?php

namespace src\tienda_virtual\controllers\buscador;

use src\tienda_virtual\controllers\Controller;
use src\tienda_virtual\database\services\products\PublicacionService;
use src\tienda_virtual\services\TwigPageFinderService;

class BuscadorController extends Controller
{
    protected PublicacionService $publicacionService;

    public function init()
    {
        parent::init();
        $this->pageFinderService = new TwigPageFinderService();
        $this->pageFinderService->session = $this->session;
        $this->publicacionService = new PublicacionService($this->connection, $this->logger);
    }

    public function buscar() : void
    {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="app";
        $jsImports[]="paw";
        $busqueda = $this->request->get("buscador")??"";
        $order = $this->request->get("order") ?? 0;
        if (!is_numeric($order) || $order > 2) {
            $order = 0;
        }
        $top = $this->request->get("page-size") ?? 6;
        if ($top > 24) {
            $top = 24;
        } else if ($top < 6) {
            $top = 6;
        }
        $skip = ($this->request->get("skip") ?? 0);
        if ($skip < 0) {
            $skip = 0;
        }
        $skip*= $top;
        $pagina = $skip;
        $totalPublicaciones = $this->publicacionService->count($busqueda ?? "");
        $totalPaginas = intdiv($totalPublicaciones, $top);
        if ($totalPaginas < $pagina) {
            $pagina = $totalPaginas;
            $skip = $pagina * $top;
        }
        $subCategory = $this->request->get("sub_categoria") ?? null;
        if ($subCategory != null) {
            if (!is_numeric($subCategory)) {
                $subCategory = null;
            } else {
                if ($subCategory < 1) {
                    $subCategory = null;
                }
            }
        }
        $publicaciones = $this->publicacionService->buscar($busqueda ?? "",
            $subCategory, $top, $skip, $order);
        $top = count($publicaciones);
        $data = ["publicaciones" => $publicaciones];
        $data["total"] = $totalPublicaciones;
        $data["paginatam"] = $top;
        $data["pagina"] = $pagina + 1;
        $data["order"] = $order;
        $this->logger->info("DATA  " . json_encode($data));
        //echo json_encode($data);
        $this->pageFinderService->findFileRute("buscador","twig","twig", $cssImports,
            $data,$busqueda, $jsImports);
    }


    public function buscarOfertas() : void
    {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="app";
        $jsImports[]="paw";
        $busqueda = $this->request->get("buscador")??"";
        $publicaciones = $this->publicacionService->buscarOfertas($busqueda ?? "",
            $this->request->get("sub_categoria") ?? null);
        $data = ["publicaciones" => $publicaciones];
        $this->pageFinderService->findFileRute("buscador","twig","twig", $cssImports,
            $data, "Ofertas", $jsImports);
    }

    /*---------------------------------ordenar por precio---------------------------------- */
    /*public function ordenarResultados() : void
    {
        $cssImports = [];
        $cssImports[] = "main";
        $jsImports = [];
        $jsImports[]="app";
        $jsImports[]="paw";
        $busqueda = $this->request->get("buscador")??"";
        $criterio = $this->request->get("order-by") ?? 1;
        if ($criterio = 1) {
            $criterio = "ASC";
        } else if ($criterio = 2) {
            $criterio = "DESC";
        }
        $publicaciones = $this->publicacionService->buscar($busqueda ?? "",
            $this->request->get("sub_categoria") ?? null, $criterio);
        $data = ["publicaciones" => $publicaciones];
        $data["ordenar"] = $criterio;
        $data["subcategorias"] =$this->subcategoriaService->RecuperarSubCategorias($categoria);
        $this->logger->info("DATA  " . json_encode($data));
        //echo json_encode($data);
        $this->pageFinderService->findFileRute("buscador","twig","twig", $cssImports,
            $data,$busqueda, $jsImports);
    }
    */
}