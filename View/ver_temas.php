<?php include '../Resources/session_start.php';
require_once '../Controler/CategoriaController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $controller = new CategoriaController();
    $categoria = $controller->obtenerCategoriaPorId($id);

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
    <?php include '../Resources/footer.php'; ?>
</body>
</html>
