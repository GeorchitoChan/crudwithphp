<?php
    namespace Core;

    class Router {
        private $routes = [];

        public function add($route, $controller, $method = "index") {
            $this->routes[$route] = ['controller' =>  $controller, 'method' => $method];
        }

        public function dispatch($url) {
            //var_dump($url);
            if (array_key_exists($url, $this->routes)) {
                $controller = "Src\\Controllers\\" . $this->routes[$url]['controller'];
                $method = $this->routes[$url]['method'];

                if (class_exists($controller)) {
                    $controllerInstance = new $controller();
                    if (method_exists($controllerInstance, $method)) {
                        $controllerInstance->$method();
                        return;
                    }
                }
            }
            echo "404 - Página no encontrada";
        }
    }