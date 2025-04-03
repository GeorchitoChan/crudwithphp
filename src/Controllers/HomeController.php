<?php
    namespace Src\Controllers;

    use Core\Controller;
    use Src\Models\User;

    class HomeController extends Controller {
        public function index() {
            $userModel = new User();
            $title = "Lista Usuarios";

            $users = $userModel->getUsers();
            $this->view("home", ["title" => $title, "users" => $users]);
        }
    }