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
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


}