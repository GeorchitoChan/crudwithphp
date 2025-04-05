<?php
    namespace Src\Controllers;

    use Core\Controller;
    use Core\Auth;
    use Src\Models\User;

    class AuthController extends Controller {
        public function login() {
            $title = "Iniciar Sesión";

            $csrf_token = Auth::generateCSRFToken();

            $this->view("login", ["title" => $title, "csrf_token" => $csrf_token]);
        }

        public function authenticate() {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (!isset($_POST['csrf_token']) || !Auth::validateCSRFToken($_POST['csrf_token'])) {
                    die("CSRF token inválido.");
                }

                Auth::limitLoginAttempts();

                $email = $_POST["email"] ?? "";
                $password = $_POST["password"] ?? "";

                $userModel = new User();
                $user = $userModel->getUserByEmail($email);

                if ($user && password_verify($password, $user["password"])) {
                    Auth::resetLoginAttempts();
                    Auth::login($user);
                    header("Location: /sherzer/public/dashboard");
                    exit();
                } else {
                    Auth::recordFailedLogin();
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