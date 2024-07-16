<?php
function renderForm($username = '', $email = '', $password = '', $error = '')
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
        if ($error != '') {
            echo '<div style="padding:4px; border:1px solid red; color:#ff0000;">' . $error . '</div>';
        }
        ?>
        <form action="../Controler/altaUsuarioController.php" method="post">
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
?>

