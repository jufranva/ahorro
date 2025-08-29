<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function login(): void
    {
        session_start();
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = User::findByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header('Location: usuarios.php');
                exit;
            }
            $error = 'Usuario o contraseña incorrectos.';
        }
        include __DIR__ . '/../views/inicio.php';
    }

    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
