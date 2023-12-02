<?php

namespace src\tienda_virtual\services;

class RequestService {

    private $post;

    public function __construct()
    {
        $this->initAlternativePost();
    }

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
        $result = $_POST[$key] ?? $_GET[$key] ?? null;
        if (is_null($result)) {
            $result = $this->post[$key] ?? null;
        }
        return $result;
    }

    private function initAlternativePost() {
        $this->post = json_decode(file_get_contents('php://input'), true);
    }
}