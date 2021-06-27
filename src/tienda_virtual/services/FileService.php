<?php

namespace src\tienda_virtual\services;

class FileService
{
    public function save(string $medico, string $path, string $file, $archivo, string $contents) : bool {
        if (!file_exists("documentos")) {
            mkdir("documentos");
        }
        if (!file_exists("documentos/$medico")){
            mkdir("documentos/$medico");
        }
        if (!file_exists($path)){
            mkdir($path);
        }
        if(!is_file($file)){
            file_put_contents($file, file_get_contents($archivo['tmp_name']));
            return true;
        }
        else {
            return false;
        }
    }
}