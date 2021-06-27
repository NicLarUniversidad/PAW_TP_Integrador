<?php

namespace src\tienda_virtual\traits;

trait TConnection {

    public $connection;

    public  function  setConnection($connection){
        $this->connection = $connection;
    }

}