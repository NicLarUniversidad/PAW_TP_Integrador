<?php


namespace src\tienda_virtual\database\repositories;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\Model;
use src\tienda_virtual\database\models\UserModel;
use src\tienda_virtual\exceptions\IndexNotFoundException;

class UserRepository extends Repository
{
    public function __construct(Logger $logger, PDO $connection)
    {
        parent::__construct($logger, $connection, "usuario", "UserModel");
    }

    /**
     * @throws IndexNotFoundException
     */
    public function findByUsernameAndPassword(string $username, string $password) : ?UserModel
    {
        $user = new UserModel();
        $user->setUsername($username);
        $queryBuilder = Model::createQueryBuilder();
        $results = $queryBuilder->select($user->getTableFields())
            ->from($this->tabla)
            ->where(["username"=>$user->getField("username")])
            ->execute();
        if (count($results) > 0) {
            if (password_verify($password, $results[0]["password"])) {
                $user->setFields($results[0]);
                return $user;
            }
        }
        return null;
    }
}