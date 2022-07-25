<?php


namespace src\tienda_virtual\database\repositories;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\models\PersonaModel;
use src\tienda_virtual\exceptions\IndexNotFoundException;

class PersonaRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "persona", "PersonaModel");
    }

    /**
     * @throws IndexNotFoundException
     */
    public function findByMail(string $mail): ?PersonaModel
    {
        $persona = new PersonaModel();
        $persona->setEmail($mail);
        $queryBuilder = Model::createQueryBuilder();
        $results = $queryBuilder->select($persona->getTableFields())
            ->from($this->tabla)
            ->where(["mail" => $persona->getField("mail")])
            ->execute();
        if (count($results) > 0) {

            $persona->setFields($results[0]);
            $this->logger->info("findByMail Class PersonaRepository");
            $this->logger->info($persona->getField("mail"));
            return $persona;
        }
        return null;
    }
}
