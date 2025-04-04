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

            foreach ($this->routes as $route => $routeDetails){
                // Compara la ruta dinámica con una expresión regular
                $pattern = preg_replace('/{([a-zA-Z0-9_]+)}/', '([a-zA-Z0-9_]+)', $route);
                $pattern = '#^' . $pattern . '$#';

                // Si coincide la ruta
                if (preg_match($pattern, $url, $matches)) {
                    // Extrae los parámetros de la ruta
                    array_shift($matches); // El primer valor es el valor completo de la ruta, lo eliminamos
                    $controller = "Src\\Controllers\\" . $routeDetails['controller'];
                    $method = $routeDetails['method'];

                    if (class_exists($controller)) {
                        $controllerInstance = new $controller();

                        if (method_exists($controllerInstance, $method)) {
                            // Llamamos al método, pasándole los parámetros extraídos
                            call_user_func_array([$controllerInstance, $method], $matches);
                            return;
                        } else {
                            echo "Método no encontrado: " . $method . "<br />";
                        }
                    } else {
                        echo "Controlador no encontrado: " . $controller . "<br />";
                    }
                }
            }

            // Si no se encuentra la ruta
            echo "Ruta no encontrada en el enrutador: " . $url . "<br />";
            echo "404 - Página no encontrada";
        }

    }