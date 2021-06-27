<?php

namespace src\tienda_virtual\services;

class SessionService
{
    public function get($key){
        return $_SESSION[$key] ?? null;
    }
    public function put($key, $value) {
        $_SESSION[$key] = $value;
    }
}