<?php


namespace src\tienda_virtual\services;

use src\tienda_virtual\traits\TSession;

class PageFinderService
{
    use TSession;
    /** @noinspection PhpIncludeInspection */
    public function findFileRute(string $name, string $folder = "html", string $type = "html",
                                     Array $cssImports = [], Array $data = [], string $title = "Clinical", $jsImports = []) : void {
        $user = $this->session->get(UserService::$USER_SESSION_NAME);
        require __DIR__ . "\\..\\views\\" . $folder . "\\" . $name . "." . $type;
    }
}