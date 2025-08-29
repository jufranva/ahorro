<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    public function index(): void
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: inicio.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            switch ($action) {
                case 'create':
                    $username = $_POST['username'] ?? '';
                    $password = $_POST['password'] ?? '';
                    if ($username && $password) {
                        User::create($username, $password);
                    }
                    break;
                case 'update':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $username = $_POST['username'] ?? '';
                    $password = $_POST['password'] ?? '';
                    if ($id && $username) {
                        User::update($id, $username, $password);
                    }
                    break;
                case 'delete':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    if ($id) {
                        User::delete($id);
                    }
                    break;
            }
            header('Location: usuarios.php');
            exit;
        }

        $users = User::all();
        include __DIR__ . '/../views/usuarios.php';
    }
}
