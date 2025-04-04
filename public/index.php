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

    $router->add("/users", "UserController", "index");
    $router->add("/users/create", "UserController", "create");
    $router->add("/users/store", "UserController", "store");
    $router->add("/users/edit/{id}", "UserController", "edit");
    $router->add("/users/update/{id}", "UserController", "update");
    $router->add("/users/delete/{id}", "UserController", "delete");
    $router->add("/users/destroy/{id}", "UserController", "destroy");

    $url = '/' . ltrim($_GET['url'] ?? '', '/');

    Auth::starSession();

    if ($url === "/dashboard" && !Auth::isLoggedIn()) {
        header("Location: /sherzer/public/login");
        exit();
    }

    $router->dispatch($url);