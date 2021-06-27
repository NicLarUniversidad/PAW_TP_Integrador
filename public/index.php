<?php

$routerService = null;

require __DIR__ . "/../src/bootstrap.php";

if (is_null($routerService)) {
    http_response_code(500);
} else {
    $routerService->direct();
}
