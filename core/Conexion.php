<?php
    namespace Core;

    use PDO;
    use PDOException;

    class Conexion {
        protected $db;

        public function __construct()
        {
            try {
                $this->db = new PDO("mysql:host=localhost;port=3307;dbname=mvc_db", "root", "");
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
    }