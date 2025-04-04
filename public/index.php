<?php
    require_once "../vendor/autoload.php";

    use Core\Auth;
    use Core\Router;

    $router = new Router();
    $router->add("/", "HomeController");
    $router->add("/login", "AuthController", "login");
    $router->add("/authenticate", "AuthController", "authenticate");
    $router->add("/logout", "AuthController", "logout");
    $router->add("/dashboard", "HomeController", "dashboard");

    $url = '/' . ltrim($_GET['url'] ?? '', '/');

    Auth::starSession();

    if ($url === "/dashboard" && !Auth::isLoggedIn()) {
        header("Location: /sherzer/public/login");
        exit();
    }

    $router->dispatch($url);