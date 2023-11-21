<?php

namespace src\tienda_virtual\exceptions;

use Throwable;

class InvalidOperationException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}