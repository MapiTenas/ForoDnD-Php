<?php
include '../Resources/session_start.php';
require_once '../Controler/TemaController.php';
require_once '../Controler/ComentarioController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $temaController = new TemaController();
    $comentarioController = new ComentarioController();

    $tema = $temaController->obtenerTemaPorId($id);
    $comentarios = $comentarioController->obtenerComentariosPorTemaId($id);

    if (!$tema) {
        echo "Tema no encontrado.";
        exit();
    }
} else {
    echo "ID de tema no proporcionado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($tema->getTitulo()); ?></title>
    <link rel="stylesheet" href="../Resources/styles.css">
</head>
<body>
<?php include '../Resources/header.php'; ?>

<div class="topic-detail-container">
    <h1 class="topic-detail-title"><?php echo htmlspecialchars($tema->getTitulo()); ?></h1>
    <p class="topic-detail-content"><?php echo nl2br(htmlspecialchars($tema->getContenido())); ?></p>
    <div class="topic-detail-footer">
        <span class="topic-detail-author">Publicado por: <?php echo htmlspecialchars($tema->getUsuarioUsername()); ?></span>
        <span class="topic-detail-date">Fecha: <?php echo htmlspecialchars($tema->getCreatedAt()); ?></span>
    </div>
</div>
<div class="comments-section">
    <h3>Respuestas</h3>
    <?php if (isset($_SESSION['username']))
        echo '<h3> Publica <a href="crear_comentario.php?id=' . htmlspecialchars($tema->getId()) . '">aqui</a> un nuevo comentario</h3>';    ?>
    <?php foreach ($comentarios as $comentario): ?>
        <div class="comment-card">
            <p class="comment-content"><?php echo nl2br(htmlspecialchars($comentario->getContenido())); ?></p>
            <div class="comment-footer">
                <span class="comment-author">Publicado por: <?php echo htmlspecialchars($comentario->getUsuarioUsername()); ?></span>
                <span class="comment-date">Fecha: <?php echo htmlspecialchars($comentario->getCreatedAt()); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include '../Resources/footer.php'; ?>
</body>
</html>
