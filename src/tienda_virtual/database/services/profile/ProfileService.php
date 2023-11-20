<?php

namespace src\tienda_virtual\database\services\profile;

use Monolog\Logger;
use PDO;
use src\tienda_virtual\services\UserService;

class ProfileService
{
    private UserService $userService;

    public function __construct(PDO $PDO, Logger $logger)
    {
        $this->userService = new UserService($PDO, $logger);
    }
}