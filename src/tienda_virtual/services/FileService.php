<?php

namespace src\tienda_virtual\services;

class FileService
{
    public function save(string $folder, string $file, $archivo) : string {
        if (!file_exists("documentos")) {
            mkdir("documentos");
        }
        if (!file_exists("documentos/$folder")){
            mkdir("documentos/$folder");
        }
        $file = "documentos/$folder/$file";
        if(!is_file($file)){
            file_put_contents($file, file_get_contents($archivo['tmp_name']));
        }
        return $file;
    }
}