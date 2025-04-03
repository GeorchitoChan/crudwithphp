<?php
    namespace Src\Models;

    use Core\Conexion;
    use PDO;

    class User extends Conexion {
        public function getUsers() {
            $smtp = $this->db->query("SELECT * FROM users");
            return $smtp->fetchAll(PDO::FETCH_ASSOC);
        }
    }