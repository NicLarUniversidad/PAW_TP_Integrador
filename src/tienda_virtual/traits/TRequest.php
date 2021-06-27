<?php

namespace src\tienda_virtual\traits;

use src\tienda_virtual\services\RequestService;

trait tRequest {

    public RequestService $request;

    public  function  setRequest(RequestService $request){
        $this->request = $request;
    }

}