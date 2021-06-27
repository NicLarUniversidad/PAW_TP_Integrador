<?php

namespace src\tienda_virtual\traits;

use Monolog\Logger;

trait TLogger {

    public Logger $logger;

    public  function  setLogger(Logger $logger){
        $this->logger = $logger;
    }

}
