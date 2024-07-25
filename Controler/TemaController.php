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
