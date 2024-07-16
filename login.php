<?php
session_start(); // Iniciar sesión PHP

include 'Model/CONNECT-DB.php'; // Asegúrate de incluir el archivo de conexión

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Consulta SQL para obtener el usuario por su nombre de usuario
    $stmt = $connection->prepare("SELECT id, username, password FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            // Usuario encontrado, verificar la contraseña
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Contraseña válida, iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirigir a la página principal o a donde desees
                header("Location: View/index.php");
                exit();
            } else {
                echo "<p>Contraseña incorrecta.</p>";
            }
        } else {
            echo "<p>Nombre de usuario incorrecto.</p>";
        }
    } else {
        echo "<p>Ocurrió un error al intentar iniciar sesión. Por favor, inténtalo de nuevo más tarde.</p>";
    }
}
?>
