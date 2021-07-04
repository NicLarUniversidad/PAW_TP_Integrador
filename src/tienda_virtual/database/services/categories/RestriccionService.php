<?php


namespace src\tienda_virtual\database\services\categories;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class RestriccionService extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\RestriccionRepository");
    }

    public function attachData(array $data = []): array
    {
        return $this->attachMetadata(parent::attachData($data));
    }

    public function attachInsertData(array $data = []) : array {
        return $this->attachMetadata(parent::attachInsertData($data));
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Restriccion";
        $data["register-url"] = "backoffice-restriccion";
        $data["item-url"] = "backoffice-restriccion-item";
        $data["insert-url"] = "backoffice-restriccion-insert";
        $data["register"]["title"] = "Agregar restriccion";
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }
}