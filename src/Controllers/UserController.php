<?php
    namespace Src\Controllers;

    use Core\Controller;
    use Core\Auth;
    use Src\Models\User;

    class UserController extends Controller {
        public function index() {
            $title = "Usuarios";
            $userModel = new User();
            $users = $userModel->getUsers();

            $this->view("users/index", ["title" => $title, "users" => $users]);
        }

        public function create() {
            $title = "Crear Usuario";
            $csrf_token = Auth::generateCSRFToken();

            $this->view("users/create", ["title" => $title, "csrf_token" => $csrf_token]);
        }

        public function store() {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (!isset($_POST['csrf_token']) || !Auth::validateCSRFToken($_POST['csrf_token'])) {
                    die("CSRF token inválido.");
                }

                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                if (empty($name) || empty($email) || empty($password)) {
                    $this->view("users/create", ["title" => "Crear Usuario", "error" => "Todos los campos son obligatorios", "csrf_token" => $_POST['csrf_token']]);
                    return;
                }

                $userModel = new User();
                $userModel->createUser($name, $email, $password);
                header("Location: /sherzer/public/users");
                exit();
            }
        }

        public function edit($id) {
            $title = "Editar Usuario";
            $userModel = new User();
            $user = $userModel->getUserById($id);
            if ($user) {
                $csrf_token = Auth::generateCSRFToken();
                $this->view("users/edit", ["title" => $title, "user" => $user, "csrf_token" => $csrf_token]);
            } else {
                // Si no se encuentra el usuario, redirigir a la lista de usuarios
                header("Location: /sherzer/public/users");
                exit();
            }
        }

        public function update($id) {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (!isset($_POST['csrf_token']) || !Auth::validateCSRFToken($_POST['csrf_token'])) {
                    die("CSRF token inválido.");
                }

                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                if (empty($email) || empty($password)) {
                    $this->view("users/edit", ["title" => "Editar Usuario", "error" => "Todos los campos son obligatorios", "csrf_token" => $_POST['csrf_token'], "user" => $_POST]);
                    return;
                }

                $userModel = new User();
                $userModel->updateUser($id, $name, $email, $password);
                header("Location: /sherzer/public/users");
                exit();
            }
        }

        public function destroy($id) {
            $userModel = new User();
            $userModel->deleteUser($id);
            header("Location: /sherzer/public/users");
            exit();
        }
    }