<?php


namespace src\tienda_virtual\database\services\categories;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\services\DatabaseService;

class SubCategoriaCaracteristicaService extends DatabaseService
{
    public function __construct(PDO $PDO, Logger $logger)
    {
        parent::__construct($PDO, $logger, "categories\\SubCategoriaCaracteristicaRepository");
    }

    public function attachData(array $data = []): array
    {
        return $this->attachMetadata(parent::attachData($data));
    }

    public function attachInsertData(array $data = []) : array {
        return $this->attachMetadata(parent::attachInsertData($data));
    }

    public function attachMetadata(array $data) : array {
        $data["table-title"] = "Asociaciones entre Sub Categorías y Características";
        $data["register-url"] = "backoffice-sub-categoria-caracteristica";
        $data["item-url"] = "backoffice-sub-categoria-caracteristica-item";
        $data["insert-url"] = "backoffice-sub-categoria-caracteristica-insert";
        $data["register"]["title"] = "Agregar asociación entre Sub Categoría y Característica";
        return $this->dataSetSelect($data,"activo",[
            "SI"=>"Sí",
            "NO"=>"No"
        ]);
    }
}