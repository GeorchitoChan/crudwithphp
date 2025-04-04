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

        public function getUserById($id) {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function createUser($name, $email, $password) {
            $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_BCRYPT)]);
        }

        public function updateUser($id, $name, $email, $password) {
            $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ?, password = ? where id = ?");
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_BCRYPT), $id]);
        }

        public function deleteUser($id) {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
        }
    }