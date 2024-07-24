<?php include '../Resources/session_start.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Foro D&D</title>
    <link rel="stylesheet" href="../Resources/styles.css">
</head>
<body>
<?php include '../Resources/header.php' ?>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
    <h2>Formulario de registro de nuevas categorias para el foro</h2>
    <div class="form-container">
        <form action="../Controler/CategoriaController.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre de la nueva categoria:</label>
                <input type="text" id="nombre" name="nombre" value="" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción para la nueva categoria:</label>
                <input type="text" id="descripcion" name="descripcion" value="" required>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Registrar</button>
            </div>
        </form>
    </div>
<?php endif; ?>


<?php include '../Resources/footer.php' ?>
</body>

</html>