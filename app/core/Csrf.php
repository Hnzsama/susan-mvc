<?php
// app/core/Csrf.php - Cross-Site Request Forgery (CSRF) Protection ala Laravel

class Csrf {
    public static function generateToken() {
        Session::start();
        if (!isset($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_token'];
    }

    public static function getToken() {
        return self::generateToken();
    }

    public static function validateToken($token = null) {
        Session::start();
        $stored = $_SESSION['_token'] ?? null;
        if (!$stored) {
            return false;
        }

        $submitted = $token ?? ($_POST['_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? null));
        return hash_equals($stored, (string)$submitted);
    }

    public static function field() {
        $token = self::getToken();
        return '<input type="hidden" name="_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
