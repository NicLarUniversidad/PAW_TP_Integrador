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
        $top = $this->request->get("page-size") ?? 6;
        if ($top > 24) {
            $top = 24;
        } else if ($top < 6) {
            $top = 6;
        }
        $skip = ($this->request->get("skip") ?? 0) * $top;
        $pagina = ($this->request->get("skip") ?? 0) + 1;
        $totalPublicaciones = $this->publicacionService->count($busqueda ?? "");
        $totalPaginas = intdiv($totalPublicaciones, $top);
        if ($totalPaginas < $pagina) {
            $pagina = $totalPaginas;
            $skip = $pagina * $top;
        }
        $publicaciones = $this->publicacionService->buscar($busqueda ?? "",
            $this->request->get("sub_categoria") ?? null, $top, $skip);
        $top = count($publicaciones);
        $data = ["publicaciones" => $publicaciones];
        $data["total"] = $totalPublicaciones;
        $data["paginatam"] = $top;
        $data["pagina"] = $pagina + 1;
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
}