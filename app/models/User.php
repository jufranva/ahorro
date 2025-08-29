<?php
require_once __DIR__ . '/../../conexion.php';

class User
{
    public static function findByUsername(string $username): ?array
    {
        $mysqli = obtenerConexion();
        if ($stmt = $mysqli->prepare('SELECT username, password FROM users WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
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
        $result = $mysqli->query('SELECT id, username FROM users');
        $users = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $users;
    }

    public static function create(string $username, string $password): bool
    {
        $mysqli = obtenerConexion();
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $mysqli->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->bind_param('ss', $username, $hash);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $username, string $password = ''): bool
    {
        $mysqli = obtenerConexion();
        if ($password !== '') {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $mysqli->prepare('UPDATE users SET username = ?, password = ? WHERE id = ?');
            $stmt->bind_param('ssi', $username, $hash, $id);
        } else {
            $stmt = $mysqli->prepare('UPDATE users SET username = ? WHERE id = ?');
            $stmt->bind_param('si', $username, $id);
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
