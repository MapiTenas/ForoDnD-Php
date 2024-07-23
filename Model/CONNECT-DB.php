<?php
/*
CONNECT-DB.PHP
Permite conectarnos a la base de datos
*/
// Variables que usamos en la base de datos para la conexión

function getDbConnection() {
    $dbname = "forodnd";
    $host = "localhost";
    $user = "root";
    $password = "";

    $connection = new mysqli($host, $user, $password, $dbname);

    if ($connection->connect_error) {
        die("No se pudo realizar la conexión: " . $connection->connect_error);
    }

    return $connection;
}
?>
