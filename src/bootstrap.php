<?php

require __DIR__. "/../vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;
use src\tienda_virtual\config\Config;
use src\tienda_virtual\database\ConnectionBuilder;
use src\tienda_virtual\database\QueryBuilder;
use src\tienda_virtual\services\RequestService;
use src\tienda_virtual\services\RouterService;
use src\tienda_virtual\services\SessionService;
use src\tienda_virtual\database\models\Model;
use \Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

if(session_id() == ''){
    //session has not started
    session_start();
}
$whoops = new Run;
$whoops ->pushHandler(new PrettyPageHandler);
$whoops->register();

$dotenv = Dotenv::createUnsafeImmutable(__DIR__.'/../');
$dotenv->load();

$config = new Config();

$log = new Logger('Clinical');
try {
    $handler = new StreamHandler($config->get("LOG_PATH"));
    $handler->setLevel($config->get("LOG_LEVEL"));
    $log->pushHandler($handler);
} catch (Exception $e) {
    //ignore
}


$connectionBuilder = new ConnectionBuilder();
$connectionBuilder->setLogger($log);
$pdo = $connectionBuilder->make($config);
QueryBuilder::$DATABASE_NAME = $config->get("DB_DBNAME")?? "";
Model::init($log, $pdo);

$whoops = new Run;
$whoops ->pushHandler(new PrettyPageHandler);
$whoops->register();

$request = new RequestService();
$routerService = new RouterService();
$session = new SessionService();
$routerService->setLogger($log);
$routerService->setConnection($pdo);
$routerService->setRequest($request);
$routerService->setSession($session);
$routerService->get('/','IndexController@get');
$routerService->get('/backoffice','BackofficeIndexController@get');
$routerService->abm('/backoffice-grupo-categoria','backoffice\\categories\\GrupoCategoriaController');
$routerService->abm('/backoffice-categoria','backoffice\\categories\\CategoriaController');
$routerService->abm('/backoffice-sub-categoria','backoffice\\categories\\SubCategoriaController');
$routerService->abm('/backoffice-caracteristica','backoffice\\categories\\CaracteristicaController');
$routerService->abm('/backoffice-valor-caracteristica','backoffice\\categories\\ValorCaracteristicaController');
$routerService->abm('/backoffice-moneda','backoffice\\categories\\MonedaController');
