<?php include '../Resources/session_start.php';
require_once '../Controler/CategoriaController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    if (isset($_POST['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        $id = intval($_POST['id']);
        $controller = new CategoriaController();
        $resultado = $controller->eliminarCategoria($id);
        if ($resultado) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error al eliminar la categoría.";
        }
    }
}

?>
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
if (isset($_SESSION['username'])) {
    echo '<h1>Bienvenido, ' . $_SESSION['username'] . '</h1>';
    // Verificar si el usuario es administrador
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        echo '<h2>Como administrador, puedes crear nuevas categorias. Haz clic <a href="crear_categoria.php">aqui</a> para ir al formulario.</h2>';
    }
}
?>



<h1>Categorias del foro</h1>

<div class="card-container">
    <?php
    require_once '../Controler/CategoriaController.php';
    $presentador = new CategoriaController();
    $categorias = $presentador->obtenerCategorias();

    if (isset($categorias) && count($categorias) > 0) {
        foreach ($categorias as $categoria) {
            echo '<div class="card">';
            echo '<h2 class="card-title">' . htmlspecialchars($categoria->getNombre()) . '</h2>';
            echo '<p class="card-description">' . htmlspecialchars($categoria->getDescripcion()) . '</p>';
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                echo '<form method="POST" action="index.php" onsubmit="return confirm(\'¿Estás seguro de que quieres eliminar esta categoría?\');">';
                echo '<input type="hidden" name="id" value="' . htmlspecialchars($categoria->getId()) . '">';
                echo '<input type="submit" name="eliminar" value="Eliminar" class="btn-delete">';
                echo '</form>';
            }
            echo '</div>';
        }
    } else {
        echo '<p>No hay categorías disponibles.</p>';
    }
    ?>
</div>

<?php include '../Resources/footer.php' ?>
</body>
</html>