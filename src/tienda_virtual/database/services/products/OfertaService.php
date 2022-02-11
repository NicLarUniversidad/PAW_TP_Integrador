<?php
namespace src\tienda_virtual\database\services\products;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class OfertaService extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "products\\OfertaRepository");
    }
    
    public function attachData(array $data = []): array
    {
        return $this->attachMetadata(parent::attachData($data));
    }
    
    public function attachInsertData(array $data = []) : array {
        return $this->attachMetadata(parent::attachInsertData($data));
    }
    
    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Ofertas";
        $data["register-url"] = "backoffice-ofertas";
        $data["item-url"] = "backoffice-ofertas-item";
        $data["insert-url"] = "backoffice-ofertas-insert";
        $data["register"]["title"] = "Agregar Oferta";
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"SI",
            "NO"=>"No"
        ]);
    }
}

