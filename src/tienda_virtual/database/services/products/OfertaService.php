<?php
namespace src\tienda_virtual\database\services\products;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class OfertaService extends DatabaseService
{
    private PublicacionService $publicacionService;
    
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "products\\OfertaRepository");
        $this->publicacionService = new PublicacionService($PDO, $logger);
    }
    
    public function attachData(array $data = []): array
    {
        return $this->attachMetadata(parent::attachData($data));
    }
    
    public function attachInsertData(array $data = []) : array {
        $data = $this->attachMetadata(parent::attachInsertData($data));
        $data = $this->formatFieldNameInsert($data, "precio_oferta", "Precio oferta");
        return $this->formatFieldNameInsert($data, "id_publicacion", "Publicacion");
    }
    
    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Ofertas";
        $data["register-url"] = "backoffice-ofertas";
        $data["item-url"] = "backoffice-ofertas-item";
        $data["insert-url"] = "backoffice-ofertas-insert";
        $data["register"]["title"] = "Agregar Oferta";
        $data = $this->dataSetSelect($data, "id_publicacion", $this->buildOptionsPublicacion());
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"SI",
            "NO"=>"No"
        ]);
    }
    
    private function buildOptionsPublicacion(): array
    {
        $options = [];
        $tuples = $this->publicacionService->findAll();
        foreach ($tuples as $tuple) {
            $options[(string)$tuple["id"]] = $tuple["descripcion"];
        }
        return $options;
    }
}

