<?php
    namespace Src\Models;

    use Core\Conexion;
    use PDO;

    class User extends Conexion {
        public function getUsers() {
            $stmt = $this->db->query("SELECT * FROM users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getUserByEmail($email) {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }