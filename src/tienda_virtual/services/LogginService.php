<?php


namespace src\tienda_virtual\services;


class LogginService
{
    public static String $mockUsername = "default";
    public static String $userId = "1";

    public static function getUsername() : String {
        return LogginService::$mockUsername;
    }

    public static function getUserId() : String
    {
        return LogginService::$userId;
    }
}