<?php
include '../Resources/session_start.php';
require_once '../Model/tema.php';

class TemaController {
    public function obtenerTemasPorCategoria($categoria_id) {
        return Tema::obtenerTemasPorCategoria($categoria_id);
    }

    public function crearTema($categoria_id, $titulo, $contenido, $usuario_id) {
        return Tema::crearTema($categoria_id, $titulo, $contenido, $usuario_id);
    }

    public function obtenerTemaPorId($id) {
        return Tema::obtenerTemaPorId($id);
    }

    public function eliminarTema($id) {
        return Tema::eliminarTema($id);
    }

}

// Manejo de la solicitud para eliminar un tema
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    if (isset($_GET['tema_id'])) {
        $tema_id = intval($_GET['tema_id']);

        // Aquí debes verificar los permisos del usuario para eliminar el tema
        // Esto es solo un ejemplo, deberías tener una validación más segura
        if (isset($_SESSION['user_id']) && (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'moderator'])) || $_SESSION['user_id'] == Tema::obtenerTemaPorId($tema_id)->getUsuarioId()) {
            $temaController = new TemaController();
            if ($temaController->eliminarTema($tema_id)) {
                header("Location: ../View/ver_temas.php?id=" . intval($_GET['id']));
                exit();
            } else {
                echo "<p>Hubo un error al eliminar el tema.</p>";
            }
        } else {
            echo "<p>No tienes permisos para eliminar este tema.</p>";
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'crear') {
    $categoria_id = intval($_POST['categoria_id']);
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $usuario_id = $_SESSION['user_id'];

    $temaController = new TemaController();
    $nuevo_tema_id = $temaController->crearTema($categoria_id, $titulo, $contenido, $usuario_id);

    if ($nuevo_tema_id) {
        header("Location: ../View/ver_temas.php?id=$categoria_id");
        exit();
    } else {
        echo "<p>Hubo un error al crear el tema.</p>";
    }


}
?>
