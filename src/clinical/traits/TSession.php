<?php


namespace src\tienda_virtual\traits;

use src\tienda_virtual\services\SessionService;

trait TSession
{
    public SessionService $session;

    public function setSession(SessionService $sessionService) {
        $this->session = $sessionService;
    }
}