<?php
    namespace Core;

    class Controller {
        public function view($view, $data = []) {
            extract($data);
            require_once "../src/Views/$view.php";
        }
    }