<?php


namespace src\tienda_virtual\database\services\categories;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class MonedaService extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\MonedaRepository");
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
        $data["register-url"] = "backoffice-moneda";
        $data["item-url"] = "backoffice-moneda-item";
        $data["insert-url"] = "backoffice-moneda-insert";
        $data["register"]["title"] = "Agregar Moneda";
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }
}