<?php


namespace src\tienda_virtual\services;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\UserModel;
use src\tienda_virtual\database\repositories\UserRepository;
use src\tienda_virtual\exceptions\IndexNotFoundException;
use src\tienda_virtual\traits\TSession;

class UserService
{
    use TSession;
    public static string $USER_SESSION_NAME = "logged_user";
    protected UserRepository $userRepository;

    public function __construct(PDO $pdo, Logger $logger)
    {
        $this->userRepository = new UserRepository($logger, $pdo);
        $this->setSession(new SessionService());
    }

    public function createUser(string $username, string $password, string $mail = "", string $id_persona = "",
                               string $activo = "") : UserModel {
        $newUser = new UserModel();
        $newUser->setUsername($username);
        $newUser->setPassword($password);
        $newUser->setEmail($mail);
        $newUser->setIdPersona($id_persona);
        $newUser->setActivo($activo);
        $this->userRepository->save($newUser);
        return $newUser;
    }

    /**
     * @throws IndexNotFoundException
     */
    public function login(string $username, string $password) : bool {
        $user = $this->userRepository->findByUsernameAndPassword($username, $password);
        if (isset($user)) {
            $this->session->put(UserService::$USER_SESSION_NAME, $user->getTableFields());
            return true;
        }
        return false;
    }

    public function getLoggedUser() : ?UserModel {
        $userData = $this->session->get(UserService::$USER_SESSION_NAME);
        if (isset($userData)) {
            $user = new UserModel();
            $user->setFields($userData);
            return $user;
        }
        return null;
    }

    public function setDefaultAddress($user, $idAddress)
    {
        $user["id_direccion_default"] = $idAddress;
        $model = $this->userRepository->getModelInstance();
        $model->setFields($user);
        $this->userRepository->update($model);
    }

    public function find($id)
    {
        return $this->userRepository->find($id)[0];
    }
}