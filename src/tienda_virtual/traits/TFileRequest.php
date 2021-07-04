<?php


namespace src\tienda_virtual\traits;


use src\tienda_virtual\services\FileRequestService;

trait TFileRequest
{
    public FileRequestService $fileRequest;

    public  function  setFileRequest(FileRequestService $request){
        $this->fileRequest = $request;
    }
}