<?php


namespace src\tienda_virtual\database\services\categories;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class ArmarPCFlujoService extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\ArmarPCFlujoRepository");
    }

    public function attachData(array $data = []): array
    {
        return $this->attachMetadata(parent::attachData($data));
    }

    public function attachInsertData(array $data = []) : array {
        return $this->attachMetadata(parent::attachInsertData($data));
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Moneda";
        $data["register-url"] = "backoffice-armar-pc-flujo";
        $data["item-url"] = "backoffice-armar-pc-flujo-item";
        $data["insert-url"] = "backoffice-armar-pc-flujo-insert";
        $data["register"]["title"] = "Agregar pasos para armar PC";
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }
}