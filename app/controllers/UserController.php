<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    public function index(): void
    {
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
                    $name = $_POST['name'] ?? '';
                    $role = isset($_POST['role']) ? (int)$_POST['role'] : 0;
                    if ($username && $password && $name && $role) {
                        User::create($username, $password, $name, $role);
                    }
                    break;
                case 'update':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $username = $_POST['username'] ?? '';
                    $password = $_POST['password'] ?? '';
                    $name = $_POST['name'] ?? '';
                    $role = isset($_POST['role']) ? (int)$_POST['role'] : 0;
                    if ($id && $username && $name && $role) {
                        User::update($id, $username, $name, $role, $password);
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
