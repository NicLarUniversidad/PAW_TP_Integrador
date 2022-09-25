<?php

namespace src\tienda_virtual\database\repositories\categories;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\misCompras\CompraImpagaModel;
use src\tienda_virtual\database\repositories\Repository;

class MisComprasRepository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "compra_impaga", "misCompras\\CompraImpagaModel");
    }
}