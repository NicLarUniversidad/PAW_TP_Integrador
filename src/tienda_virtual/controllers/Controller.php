<?php


namespace src\tienda_virtual\controllers;


use src\tienda_virtual\services\PageFinderService;
use src\tienda_virtual\services\UserService;
use src\tienda_virtual\traits\TConnection;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TRequest;
use src\tienda_virtual\traits\TSession;

class Controller
{
    use TSession;
    use TRequest;
    use TLogger;
    use TConnection;

    public PageFinderService $pageFinderService;

    public function __construct()
    {
        $this->pageFinderService = new PageFinderService();
    }

    public function init() {
        $this->pageFinderService->setSession($this->session);
    }

    public function isAuthorizedUser($method) : bool {
        return true;
    }

    protected function isLoggedUser() {
        $user = $this->session->get(UserService::$USER_SESSION_NAME);
        return !is_null($user);
    }

    protected function isAdmin() {
        $user = $this->session->get(UserService::$USER_SESSION_NAME);
        if (is_null($user)) {
            return false;
        }
        else {
            return $user["username"] == "admin";
        }
    }
}