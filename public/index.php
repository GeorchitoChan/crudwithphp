<?php
    require_once "../vendor/autoload.php";

    use Core\Router;

    $router = new Router();
    //$router->add("/", "HomeController");

    $url = $_GET['url'] ?? "/";
    $router->dispatch($url);