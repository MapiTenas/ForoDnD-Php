<?php include '../Resources/session_start.php';
require_once '../Controler/CategoriaController.php';
require_once '../Controler/TemaController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $categoriaController = new CategoriaController();
    $temaController = new TemaController();

    $categoria = $categoriaController->obtenerCategoriaPorId($id);
    $temas = $temaController->obtenerTemasPorCategoria($id);

    if ($categoria) {
        $nombreCategoria = $categoria->getNombre();
    } else {
        echo "Categoría no encontrada.";
        exit();
    }
} else {
    echo "ID de categoría no proporcionado.";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Temas de la Categoría</title>
    <link rel="stylesheet" href="../Resources/styles.css">
</head>
<body>
    <?php include '../Resources/header.php'; ?>
    <h1>Temas de la Categoría: <?php echo htmlspecialchars($nombreCategoria); ?></h1>
    <?php
    if (isset($_SESSION['username'])) {
        echo '<h2> Publica <a href="crear_tema.php?id=' . htmlspecialchars($categoria->getId()) . '">aqui</a> un nuevo tema</h2>';
    }
    ?>
    <div class="topic-container">
        <?php foreach ($temas as $tema): ?>
            <div class="topic-card">
                <h3 class="topic-title"><?php echo htmlspecialchars($tema->getTitulo()); ?></h3>
                <p class="topic-content"><?php echo htmlspecialchars(substr($tema->getContenido(), 0, 100)) . '...'; ?></p>
                <div class="topic-footer">
                    <span class="topic-author">Publicado por: <?php echo htmlspecialchars($tema->getUsuarioUsername()); ?></span>
                    <span class="topic-date">Fecha: <?php echo htmlspecialchars($tema->getCreatedAt()); ?></span>
                </div>
                <div class="button-container">
                    <a href="ver_tema_detalle.php?id=<?php echo htmlspecialchars($tema->getId()); ?>" class="btn-view">Ver Tema</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php include '../Resources/footer.php'; ?>
</body>
</html>
