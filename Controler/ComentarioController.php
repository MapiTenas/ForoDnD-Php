<?php
require_once '../Model/Comentario.php';

class ComentarioController {

    public function obtenerComentariosPorTemaId($tema_id) {
        return Comentario::obtenerComentariosPorTemaId($tema_id);
    }


    public function crearComentario($contenido, $tema_id, $usuario_id) {
        Comentario::crearComentario($contenido, $tema_id, $usuario_id);
    }

}
?>
