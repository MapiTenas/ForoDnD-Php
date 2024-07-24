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
        $connection = getDbConnection($connection);
        $usuario = new Usuario($connection);
        if ($usuario->createUser($username, $email, $password)) {
            // Enviar correo de bienvenida
            $to = $email;
            $subject = 'Bienvenido/a al foro de Dungeons & Dragons';
            $message = "Hola $username,\n\nGracias por registrarte en nuestro foro de Dungeons & Dragons. Esperamos que disfrutes de nuestra comunidad.\n\nSaludos!";
            $headers = 'From: dungeonsdragonsforophp@gmail.com' . "\r\n" .
                'Reply-To: dungeonsdragonsforophp@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            try {
                if (!mail($to, $subject, $message, $headers)) {
                    throw new Exception('Error al enviar correo de bienvenida');
                }
            } catch (Exception $e) {
            }
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