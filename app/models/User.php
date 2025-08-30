<?php
require_once __DIR__ . '/../../conexion.php';

class User
{
    public static function findByUsername(string $username): ?array
    {
        $mysqli = obtenerConexion();
        if ($stmt = $mysqli->prepare('SELECT username, password, name, role FROM users WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if ($user) {
                $user['role'] = (int)$user['role'];
            }
            $stmt->close();
            $mysqli->close();
            return $user ?: null;
        }
        $mysqli->close();
        return null;
    }

    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, username, name, role FROM users');
        $users = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($users as &$user) {
            $user['role'] = (int)$user['role'];
        }
        $mysqli->close();
        return $users;
    }

    public static function create(string $username, string $password, string $name, int $role): bool
    {
        $mysqli = obtenerConexion();
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $mysqli->prepare('INSERT INTO users (username, password, name, role) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('sssi', $username, $hash, $name, $role);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $username, string $name, int $role, string $password = ''): bool
    {
        $mysqli = obtenerConexion();
        if ($password !== '') {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $mysqli->prepare('UPDATE users SET username = ?, password = ?, name = ?, role = ? WHERE id = ?');
            $stmt->bind_param('sssii', $username, $hash, $name, $role, $id);
        } else {
            $stmt = $mysqli->prepare('UPDATE users SET username = ?, name = ?, role = ? WHERE id = ?');
            $stmt->bind_param('ssii', $username, $name, $role, $id);
        }
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function delete(int $id): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('DELETE FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
