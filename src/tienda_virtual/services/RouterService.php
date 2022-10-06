<?php
namespace src\tienda_virtual\services;

use Exception;
use src\tienda_virtual\exceptions\PageNotFoundException;
use src\tienda_virtual\traits\TSession;
use src\tienda_virtual\traits\TRequest;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\traits\TConnection;

class RouterService{

    use TSession;
    use TRequest;
    use TLogger;
    use TConnection;

    public array $routes = [
        "GET" =>[],
        "POST"=>[],
        "PUT"=>[],
        "DELETE"=>[],
    ];

    public function loadRoutes($path, $action, $method = "GET") {
        $this->routes[$method][$path]= $action;
    }

    public function get($path,$action) {
        $this->loadRoutes($path,$action,"GET");
    }

    public function post($path,$action) {
        $this->loadRoutes($path,$action,"POST");
    }

    public function put($path,$action) {
        $this->loadRoutes($path,$action,"PUT");
    }

    public function delete($path,$action) {
        $this->loadRoutes($path,$action,"DELETE");
    }

    public function abm($path, $controllerName) {
        $action = "$controllerName@";
        $this->loadRoutes($path . "-item",$action . "delete","DELETE");
        $this->loadRoutes($path,$action . "get");
        $this->loadRoutes($path . "-insert",$action . "put","POST");
        $this->loadRoutes($path . "-item",$action . "post");
    }

    public function exist ($path,$method) {
        return array_key_exists($path,$this->routes[$method]);

    }

    /**
     * @throws PageNotFoundException
     */
    public function getController($path, $http_method) {
        $this->logger->info("getController($path, $http_method)");
        if (!$this->exist($path,$http_method)){
            $this->logger->warning("Se quiso acceder a un path que no existe: ". $path);
            throw new PageNotFoundException("la ruta no existe para este path");
        }
        return explode('@',$this->routes[$http_method][$path]);
    }

    public function call($controller, $method) {
        $controller_name = "src\\tienda_virtual\\controllers\\{$controller}";
        $objController = new $controller_name;
        $objController->setSession($this->session);
        $objController->setConnection($this->connection);
        $objController->setRequest($this->request);
        $objController->setLogger($this->logger);
        $objController->init();
        $objController->$method();
    }

    public function  direct() {
        list($path, $http_method) = $this->request->route();
        try {
            list($controller, $method) = $this->getController($path, $http_method);
            $this->logger
                ->info(
                    "Status Code: 200",
                    [
                        "Path"=>$path,
                        "Method" =>$http_method,
                    ]
                );
            $this->call($controller,$method);
        } catch (PageNotFoundException $e) {
            $this->call("ProblemsController","pageNotFound");
        } catch (Exception $ex) {
            $this->call("ProblemsController","serverInternalError");
        }
    }
}