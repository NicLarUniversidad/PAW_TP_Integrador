<?php

namespace src\tienda_virtual\exceptions;

use Exception;
use Throwable;

class PageNotFoundException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function get()
    {
        return view('not-found');
    }
}