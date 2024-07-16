<?php
/*
Permite a los usuarios crear una nueva entrada en la base de datos
*/

// Crear el nuevo formulario de registro
function renderForm($username, $email, $password, $error)
{
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Alta de nuevo usuario</title>
        <link rel="stylesheet" href="../Resources/styles.css">
    </head>
    <body>
    <?php include '../Resources/header.php' ?>
    <h1>Alta de nuevo usuario</h1>
    <h2>¡Bienvenid@! </h2>
    <h3>Estás apunto de unirte al foro con la comunidad más activa en castellano del juego de rol más importante del mundo. </h3>
    <h3>Recuerda loggearte para postear :)</h3>
    <div class="form-container">
        <?php
        // Si hay errores, los muestra en pantalla
        if ($error != '') {
            echo '<div style="padding:4px; border:1px solid red; color:#ff0000;">' . $error . '</div>';
        }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Nombre de usuario:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Registrar</button>
            </div>
        </form>
    </div>
    <br>
    <?php include '../Resources/footer.php' ?>
    </body>
    </html>
    <?php
}

include('../Model/connect-db.php');

// Comprueba si el formulario ha sido enviado.
// Si se ha enviado, comienza el proceso el formulario y guarda los datos en la DB
if (isset($_POST['submit'])) {
    // Obtenemos los datos del formulario, asegurándonos que son válidos.
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Comprueba que todos los campos han sido introducidos
    if ($username == '' || $email == '' || $password == '') {
        // Genera el mensaje de error
        $error = 'ERROR: Por favor, introduce todos los campos requeridos.!';
        // Si algún campo está en blanco, muestra el formulario otra vez
        renderForm($username, $email, $password, $error);
    } else {
        // Guardamos los datos en la base de datos
        $sentencia = "INSERT INTO usuarios (username, email, password) VALUES ('$username', '$email', '$password')" or die(mysqli_error($connection));

        mysqli_query($connection, $sentencia);
        /* Una vez que han sido guardados, redirigimos a la página de vista principal*/
        header("Location: index.php");
    }
} else {
    // Si el formulario no ha sido enviado, muestra el formulario
    renderForm('', '', '', '');
}
?>
