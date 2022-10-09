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
//MercadoPago\SDK::setAccessToken($config->get("MP_ACCESS_TOKEN"));
//MercadoPago\SDK::setIntegratorId($config->get("MP_INTEGRATOR_ID"));
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
$routerService->get('/backoffice-informes','InformeController@get');
$routerService->abm('/backoffice-grupo-categoria','backoffice\\categories\\GrupoCategoriaController');
$routerService->abm('/backoffice-categoria','backoffice\\categories\\CategoriaController');
$routerService->abm('/backoffice-producto','backoffice\\products\\ProductoController');
$routerService->abm('/backoffice-producto-sub-categoria','backoffice\\products\\ProductoSubCategoriaController');
$routerService->abm('/backoffice-fotografia-producto','backoffice\\products\\FotografiaProductoController');
$routerService->abm('/backoffice-stock','backoffice\\products\\StockController');
$routerService->abm('/backoffice-publicacion','backoffice\\products\\PublicacionController');
$routerService->abm('/backoffice-sub-categoria','backoffice\\categories\\SubCategoriaController');
$routerService->abm('/backoffice-caracteristica','backoffice\\categories\\CaracteristicaController');
$routerService->abm('/backoffice-sub-categoria-caracteristica','backoffice\\categories\\SubCategoriaCaracteristicaController');
$routerService->abm('/backoffice-valor-caracteristica','backoffice\\categories\\ValorCaracteristicaController');
$routerService->abm('/backoffice-moneda','backoffice\\categories\\MonedaController');
$routerService->abm('/backoffice-ofertas','backoffice\\categories\\OfertaController');
$routerService->abm('/backoffice-armar-pc-flujo','backoffice\\categories\\ArmarPCFlujoController');
$routerService->abm('/backoffice-restriccion','backoffice\\categories\\RestriccionController');

$routerService->get('/login','LoginController@get');
$routerService->post('/login','LoginController@post');
$routerService->get('/registrarse','LoginController@getRegistrarse');
$routerService->post('/registrarse','LoginController@postRegistrarse');
$routerService->get('/logout','LoginController@getLogout');

//Buscador
$routerService->get('/buscar','buscador\\BuscadorController@buscar');
$routerService->get('/arma-tu-pc','armartupc\\ArmarTuPcController@mostrarTemplate');
$routerService->get('/carrito','carrito\\CarritoController@mostrarTemplate');
$routerService->get('/carrito-cancelar','carrito\\CarritoController@cancelar');
$routerService->get('/grupocategorias','grupocategoria\\GrupoCategoriaController@mostrarGrupoCategorias');
$routerService->get('/categorias','categoria\\CategoriaController@mostrarCategorias');
$routerService->get('/subcategoria','subcategoria\\SubCategoriaController@mostrarSubCategorias');
$routerService->get('/ofertas','oferta\\OfertaController@mostrarOfertas');
$routerService->get('/detalleproducto','detalleProducto\\DetalleProductoController@mostrarDetalles');
$routerService->get('/miscompras','misCompras\\MisComprasController@mostrarMisCompras');

//Errores
$routerService->get('/not_found', 'PageNotFoundException@get');
$routerService->get('/server_error', 'IndexNotFoundException@get');