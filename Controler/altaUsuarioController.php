<?php
include('../Model/CONNECT-DB.php');
include('../Model/usuario.php');
include('../View/AltaUsuario.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($username == '' || $email == '' || $password == '') {
        $error = 'ERROR: Por favor, introduce todos los campos requeridos.';
        renderForm($username, $email, $password, $error);
    } else {
        $usuario = new Usuario($connection);
        if ($usuario->createUser($username, $email, $password)) {
            header("Location: ../index.php");
        } else {
            $error = 'ERROR: No se pudo crear el usuario. Inténtalo de nuevo.';
            renderForm($username, $email, $password, $error);
        }
    }
} else {
    renderForm();
}
?>