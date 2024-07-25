<?php
include '../Resources/session_start.php';
require_once '../Controler/ComentarioController.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contenido = $_POST['contenido'];
    $tema_id = intval($_POST['tema_id']);
    $usuario_id = intval($_SESSION['user_id']);

    $comentarioController = new ComentarioController();
    $comentarioController->crearComentario($contenido, $tema_id, $usuario_id);

    header('Location: ver_tema_detalle.php?id=' . $tema_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Publicar Comentario</title>
    <link rel="stylesheet" href="../Resources/styles.css">
</head>
<body>
<?php include '../Resources/header.php'; ?>

<div class="form-container">
    <form action="crear_comentario.php" method="post">
        <div class="form-group">
            <label for="contenido">Escribe aquí tu comentario</label>
            <textarea id="contenido" name="contenido" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit" name="submit">Enviar comentario</button>
        </div>
        <input type="hidden" name="tema_id" value="<?php echo intval($_GET['id']); ?>">
    </form>
</div>

<?php include '../Resources/footer.php'; ?>
</body>
</html>
