<?php include '../Resources/session_start.php'; ?>
<?php
function renderForm($username = '', $email = '', $password = '')
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
    <br>
    <div class="form-container">
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
    <div id="error-popup" class="popup"></div>
    <br>
    <?php include '../Resources/footer.php' ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener el mensaje de error de la sesión PHP
            var errorMsg = "<?php echo isset($_SESSION['register_error']) ? $_SESSION['register_error'] : ''; ?>";
            if (errorMsg) {
                // Mostrar el popup con el mensaje de error
                var popup = document.getElementById("error-popup");
                popup.textContent = errorMsg;
                popup.style.display = "block";

                // Ocultar el popup después de 5 segundos
                setTimeout(function() {
                    popup.style.display = "none";
                }, 5000);

                // Limpiar el mensaje de error después de mostrarlo
                <?php $_SESSION['register_error'] = ''; ?>
            }
        });
    </script>




    </body>
    </html>
    <?php
}
?>

