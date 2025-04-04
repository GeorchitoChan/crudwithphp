<?php
    namespace Core;

    class Router {
        private $routes = [];

        public function add($route, $controller, $method = "index") {
            $this->routes[$route] = ['controller' =>  $controller, 'method' => $method];
        }

        public function dispatch($url) {
            // Verifica las rutas registradas
            // var_dump($this->routes);

            // echo "URL solicitada: " . $url . "<br />";  // Verifica si el valor de $url es el esperado
            if (array_key_exists($url, $this->routes)) {
                $controller = "Src\\Controllers\\" . $this->routes[$url]['controller'];
                $method = $this->routes[$url]['method'];

                if (class_exists($controller)) {
                    $controllerInstance = new $controller();
                    if (method_exists($controllerInstance, $method)) {
                        $controllerInstance->$method();
                        return;
                    } else {
                        echo "Método no encontrado: " . $method . "<br />";
                    }
                } else {
                    echo "Controlador no encontrado: " . $controller . "<br />";
                }
            } else {
                echo "Ruta no encontrada en el enrutador: " . $url . "<br />";
            }

            echo "404 - Página no encontrada";
        }

    }