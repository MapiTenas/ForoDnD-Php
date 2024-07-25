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

<?php
if (isset($_SESSION['username'])) :
    require_once '../Controler/TemaController.php';

    // Recupero el id de la categoria para poder pasarlo al método POST
    $categoria_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

    if (isset($_POST['submit'])) {
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $usuario_id = $_SESSION['user_id'];

        $temaController = new TemaController();
        $nuevo_tema_id = $temaController->crearTema($categoria_id, $titulo, $contenido, $usuario_id);

        if ($nuevo_tema_id) {
            echo "<p>Tema creado exitosamente!</p>";
        } else {
            echo "<p>Hubo un error al crear el tema.</p>";
        }
    }
    ?>

    <h2>Postea un nuevo tema</h2>
    <div class="form-container">
        <form action="" method="post">
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
        </form>
    </div>
<?php endif; ?>



<?php include '../Resources/footer.php' ?>
</body>

</html>