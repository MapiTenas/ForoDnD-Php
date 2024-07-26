<?php
require_once '../Model/Comentario.php';

class ComentarioController {

    public function obtenerComentariosPorTemaId($tema_id) {
        return Comentario::obtenerComentariosPorTemaId($tema_id);
    }


    public function crearComentario($contenido, $tema_id, $usuario_id) {
        Comentario::crearComentario($contenido, $tema_id, $usuario_id);
    }

    public function eliminarComentarioPorId($id) {
        $comentario = Comentario::obtenerComentarioPorId($id);
        if ($comentario) {
            $isAuthor = $_SESSION['user_id'] == $comentario->getUsuarioId();
            $isAdminOrModerator = isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'moderator']);
            if ($isAuthor || $isAdminOrModerator) {
                Comentario::eliminarComentarioPorId($id);
            } else {
                throw new Exception('No tienes permiso para eliminar este comentario.');
            }
        } else {
            throw new Exception('Comentario no encontrado.');
        }
    }


}
?>
