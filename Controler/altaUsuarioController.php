<?php
include '../Resources/session_start.php';
include('../Model/CONNECT-DB.php');
include('../Model/usuario.php');
include('../View/AltaUsuario.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($username == '' || $email == '' || $password == '') {
        $_SESSION['register_error'] = 'ERROR: Por favor, introduce todos los campos requeridos.';
        header("Location: ../Controler/altaUsuarioController.php");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = 'ERROR: Por favor, introduce un correo electrónico válido.';
        header("Location: ../Controler/altaUsuarioController.php");
        exit();
    } else {
        $usuario = new Usuario($connection);
        if ($usuario->createUser($username, $email, $password)) {
            header("Location: ../View/index.php");
            exit();
        } else {
            $_SESSION['register_error'] = 'ERROR: No se pudo crear el usuario. Inténtalo de nuevo.';
            header("Location: ../Controler/altaUsuarioController.php");
            exit();
        }
    }
} else {
    renderForm();
}
?>