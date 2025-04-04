<?php
    namespace Core;

    class Auth {
        public static function starSession() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }

        public static function login($user) {
            self::starSession();
            $_SESSION['user'] = $user;
        }

        public static function isLoggedIn() {
            self::starSession();
            return isset($_SESSION['user']);
        }

        public static function logout() {
            self::starSession();
            session_destroy();
        }

        public static function getUser() {
            self::starSession();
            return $_SESSION['user'] ?? null;
        }

        // Protección contra CSRF (Cross-Site Request Forgery)
        public static function generateCSRFToken() {
            self::starSession();

            // Generar y almacenar el token CSRF en la sesión
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            return $_SESSION['csrf_token']; 
        }

        public static function getCSRFToken() {
            self::starSession();
            return $_SESSION['csrf_token'] ?? '';
        }

        public static function validateCSRFToken($token) {
            self::starSession();
            return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
        }
    }