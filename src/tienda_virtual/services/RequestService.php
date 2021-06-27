<?php

namespace src\tienda_virtual\services;

class RequestService {

    public function  uri(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public  function method (){
        return $_SERVER['REQUEST_METHOD'];
    }

    public function route (){
        return[
            $this->uri(),
            $this->method(),
        ];
    }

    public function get($key){
        return $_POST[$key] ?? $_GET[$key] ?? null;
    }
}