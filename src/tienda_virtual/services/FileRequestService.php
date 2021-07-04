<?php


namespace src\tienda_virtual\services;


class FileRequestService
{
    public function get($key){
        return $_FILES[$key] ?? null;
    }
}