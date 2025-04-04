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
    }