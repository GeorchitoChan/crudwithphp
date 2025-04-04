<?php
    namespace Src\Controllers;

    use Core\Controller;
    use Core\Auth;
    use Src\Models\User;

    class AuthController extends Controller {
        public function login() {
            $title = "Iniciar Sesión";
            $this->view("login", ["title" => $title]);
        }

        public function authenticate() {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $email = $_POST["email"] ?? "";
                $password = $_POST["password"] ?? "";

                $userModel = new User();
                $user = $userModel->getUserByEmail($email);

                if ($user && password_verify($password, $user["password"])) {
                    Auth::login($user);
                    header("Location: /sherzer/public/dashboard");
                    exit();
                } else {
                    $this->view("login", ["title" => "Iniciar Sesión", "error" => "Credenciales incorrectas"]);
                }
            }
        }

        public function logout() {
            Auth::logout();
            header("Location: /sherzer/public/login");
            exit();
        }
    }