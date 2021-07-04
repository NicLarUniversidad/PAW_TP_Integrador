<?php

namespace src\tienda_virtual\services;

class FileService
{
    public function save(string $folder, string $path, string $file, $archivo) : bool {
        if (!file_exists("documentos")) {
            mkdir("documentos");
        }
        if (!file_exists("documentos/$folder")){
            mkdir("documentos/$folder");
        }
        if (!file_exists("documentos/$folder/$path")){
            mkdir("documentos/$folder/$path");
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