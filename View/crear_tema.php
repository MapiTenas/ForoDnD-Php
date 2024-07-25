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

<?php if (isset($_SESSION['username'])) : ?>
    <h2>Postea un nuevo tema</h2>
    <h3>Recuerda que los temas deben ir acordes a la categoria.</h3>

    <div class="form-container">
        <form action="../Controler/TemaController.php?action=crear" method="post">
            <div class="form-group">
                <label for="titulo">Titulo del nuevo tema:</label>
                <input type="text" id="titulo" name="titulo" value="" required>
            </div>
            <div class="form-group">
                <label for="contenido">Escribe aquí el contenido del tema</label>
                <textarea id="contenido" name="contenido" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Enviar nuevo tema</button>
            </div>
            <input type="hidden" name="categoria_id" value="<?php echo intval($_GET['id'] ?? 1); ?>">
        </form>
    </div>
<?php endif; ?>
<?php include '../Resources/footer.php' ?>
</body>

</html>