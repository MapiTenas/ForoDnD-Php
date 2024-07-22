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


}