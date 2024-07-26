<?php

class Usuario {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function createUser($username, $email, $password) {
        $username = htmlspecialchars($username);
        $email = htmlspecialchars($email);
        $password = password_hash(htmlspecialchars($password), PASSWORD_BCRYPT);

        $stmt = $this->connection->prepare("INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Código de error para duplicación de entrada
                $_SESSION['register_error'] = 'ERROR: El nombre de usuario o el correo electrónico ya están en uso.';
            } else {
                $_SESSION['register_error'] = 'ERROR: Ocurrió un problema al intentar registrar el usuario.';
            }
            return false;
        }

    }

    // Método para obtener todos los usuarios
    public function getUsers() {
        $stmt = $this->connection->prepare("SELECT id, username, email FROM usuarios");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Método para eliminar un usuario
    public function deleteUser($userId) {
        // Paso 1: Eliminar todos los comentarios de los temas creados por el usuario
        $stmt = $this->connection->prepare("
            DELETE comentarios FROM comentarios 
            INNER JOIN temas ON comentarios.tema_id = temas.id 
            WHERE temas.usuario_id = ?
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        // Paso 2: Eliminar todos los temas creados por el usuario
        $stmt = $this->connection->prepare("DELETE FROM temas WHERE usuario_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        // Paso 3: Eliminar todos los comentarios realizados por el usuario en otros temas
        $stmt = $this->connection->prepare("DELETE FROM comentarios WHERE usuario_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        // Paso 4: Finalmente, eliminar el usuario
        $stmt = $this->connection->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }
}