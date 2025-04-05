<?php
    namespace Core;

    class Auth {
        public static function startSession() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();

                // 🔐 Protege contra secuestro de sesión
                if (!isset($_SESSION['session_created'])) {
                    $_SESSION['session_created'] = time();
                } elseif (time() - $_SESSION['session_created'] > 1800) { // 30 min
                    session_regenerate_id(true);
                    $_SESSION['session_created'] = time();
                }

                // 🛡 Evita robo de sesión con fingerprint
                $fingerprint = hash('sha256', $_SERVER['HTTP_USER_AGENT'] . session_id());
                if (!isset($_SESSION['fingerprint'])) {
                    $_SESSION['fingerprint'] = $fingerprint;
                } elseif ($_SESSION['fingerprint'] !== $fingerprint) {
                    session_destroy();
                    die("Posible secuestro de sesión detectado.");
                }

                // 🏴‍☠️ Protección contra fijación de sesión
                ini_set("session.use_strict_mode", 1);
                ini_set("session.cookie_httponly", 1);
                ini_set("session.cookie_secure", 1);
                ini_set("session.use_only_cookies", 1);
            }
        }

        public static function login($user) {
            self::startSession();
            $_SESSION['user'] = $user;
            session_write_close(); // Permite liberar el bloqueo de sesión
        }

        public static function isLoggedIn() {
            self::startSession();
            return isset($_SESSION['user']);
        }

        public static function logout() {
            self::startSession();
            session_unset();
            session_destroy();
        }

        public static function getUser() {
            self::startSession();
            return $_SESSION['user'] ?? null;
        }

        // Protección contra CSRF (Cross-Site Request Forgery)
        public static function generateCSRFToken() {
            self::startSession();

            // Generar y almacenar el token CSRF en la sesión
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            return $_SESSION['csrf_token'];
        }

        public static function getCSRFToken() {
            self::startSession();
            return $_SESSION['csrf_token'] ?? '';
        }

        public static function validateCSRFToken($token) {
            self::startSession();
            return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
        }

        public static function limitLoginAttempts() {
            self::startSession();
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = 0;
            }

            if ($_SESSION['login_attempts'] >= 5) {
                die("Demasiados intentos fallidos. Intenta más tarde.");
            }
        }

        public static function recordFailedLogin() {
            self::startSession();
            $_SESSION['login_attempts']++;
        }

        public static function resetLoginAttempts() {
            self::startSession();
            $_SESSION['login_attempts'] = 0;
        }
    }